<?php
/**
 * @author Carsten Brandt <mail@cebe.cc>
 */

namespace yii\apidoc\commands;

use yii\apidoc\models\Context;
use yii\apidoc\renderers\BaseRenderer;
use yii\apidoc\renderers\GuideRenderer;
use yii\helpers\Console;
use yii\helpers\FileHelper;
use Yii;

/**
 * This command can render documentation stored as markdown files such as the yii guide
 * or your own applications documentation setup.
 *
 */
class GuideController extends BaseController
{
	/**
	 * @var string path or URL to the api docs to allow links to classes and properties/methods.
	 */
	public $apiDocs;

	/**
	 * Renders API documentation files
	 * @param array $sourceDirs
	 * @param string $targetDir
	 * @return int
	 */
	public function actionIndex(array $sourceDirs, $targetDir)
	{
		$renderer = $this->findRenderer($this->template);
		$targetDir = $this->normalizeTargetDir($targetDir);
		if ($targetDir === false || $renderer === false) {
			return 1;
		}

		// setup reference to apidoc
		if ($this->apiDocs !== null) {
			$renderer->apiUrl = $this->apiDocs;
			$renderer->apiContext = $this->loadContext($this->apiDocs);
			$this->updateContext($renderer->apiContext); // TODO autodetect API docs in same folder
		} else {
			$renderer->apiContext = new Context();
		}

		// search for files to process
		$files = $this->searchFiles($sourceDirs);

		$renderer->controller = $this;
		$renderer->render($files, $targetDir);

		$this->stdout('Publishing images...');
		foreach($sourceDirs as $source) {
			FileHelper::copyDirectory(rtrim($source, '/\\') . '/images', $targetDir . '/images');
		}
		$this->stdout('done.' . PHP_EOL, Console::FG_GREEN);


		// TODO generate api references.txt
	}

	protected function findFiles($path, $except = ['README.md'])
	{
		$path = FileHelper::normalizePath($path);
		$options = [
			'only' => ['*.md'],
			'except' => $except,
		];
		return FileHelper::findFiles($path, $options);
	}
	/**
	 * @return GuideRenderer
	 */
	protected function findRenderer($template)
	{
		$rendererClass = 'yii\\apidoc\\templates\\' . $template . '\\GuideRenderer';
		if (!class_exists($rendererClass)) {
			$this->stderr('Renderer not found.' . PHP_EOL);
			return false;
		}
		return new $rendererClass();
	}
}