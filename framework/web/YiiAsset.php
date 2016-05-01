<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\web;

/**
 * This asset bundle provides the base javascript files for the Yii Framework.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class YiiAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@yii/assets';

    /**
     * @inheritdoc
     */
    public $js = ['yii.js',];

    /**
     * @inheritdoc
     */
    public $depends = [JqueryAsset::class];
}
