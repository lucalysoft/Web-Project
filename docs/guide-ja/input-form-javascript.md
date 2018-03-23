�N���C�A���g�T�C�h�� ActiveForm ���g������
==========================================

[[yii\widgets\ActiveForm]] �E�B�W�F�b�g�́A�N���C�A���g�o���f�[�V�����̂��߂Ɏg����A�� JavaScript ���\�b�h������Ă��܂��B
���̎����͔��ɏ_��ŁA�l�X�ȕ��@�Ŋg�����邱�Ƃ��\�ɂȂ��Ă��܂��B
���L�ł���ɂ��ĉ�����܂��B

## ActiveForm �C�x���g

ActiveForm �́A��A�̐�p�̃C�x���g�𔭐������܂��B
���̂悤�ȃR�[�h���g���āA�����̃C�x���g���w�ǂ��ď������邱�Ƃ��o���܂��B

```javascript
$('#contact-form').on('beforeSubmit', function (e) {
	if (!confirm("�S�ăI�[�P�[�B���M���܂���?")) {
		return false;
	}
	return true;
});
```

�ȉ��A���p�ł���C�x���g�����Ă����܂��傤�B

### `beforeValidate`

`beforeValidate` �́A�t�H�[���S�̂����؂���O�Ƀg���K�[����܂��B

�C�x���g�n���h���̃V�O�j�`���͈ȉ��̒ʂ�:

```javascript
function (event, messages, deferreds)
```

�����͈ȉ��̒ʂ�:

- `event`: �C�x���g�̃I�u�W�F�N�g�B
- `messages`: �A�z�z��ŁA�L�[�͑����� ID�A�l�͑Ή����鑮���̃G���[���b�Z�[�W�̔z��ł��B
- `deferreds`: Deferred �I�u�W�F�N�g�̔z��B`deferreds.add(callback)` ���g���āA�V���� deferrd �Ȍ��؂�ǉ����邱�Ƃ��o���܂��B

�n���h�����^�U�l `false` ��Ԃ��ƁA���̃C�x���g�ɑ����t�H�[���̌��؂͒��~����܂��B
���̌��ʁA`afterValidate` �C�x���g���g���K�[����܂���B

### `afterValidate`

`afterValidate` �C�x���g�́A�t�H�[���S�̂����؂�����Ńg���K�[����܂��B

�C�x���g�n���h���̃V�O�j�`���͈ȉ��̒ʂ�:

```javascript
function (event, messages, errorAttributes)
```

�����͈ȉ��̒ʂ�:

- `event`: �C�x���g�̃I�u�W�F�N�g�B
- `messages`: �A�z�z��ŁA�L�[�͑����� ID�A�l�͑Ή����鑮���̃G���[���b�Z�[�W�̔z��ł��B
- `errorAttributes`: ���؃G���[�����鑮���̔z��B���̈����̍\���ɂ��Ă� `attributeDefaults` ���Q�Ƃ��ĉ������B

### `beforeValidateAttribute`

`beforeValidateAttribute` �C�x���g�́A���������؂���O�Ƀg���K�[����܂��B

�C�x���g�n���h���̃V�O�j�`���͈ȉ��̒ʂ�:

```javascript
function (event, attribute, messages, deferreds)
```
     
�����͈ȉ��̒ʂ�:

- `event`: �C�x���g�̃I�u�W�F�N�g�B
- `attribute`: ���؂���鑮���B���̈����̍\���ɂ��Ă� `attributeDefaults` ���Q�Ƃ��ĉ������B
- `messages`: �w�肳�ꂽ�����ɑ΂��錟�؃G���[���b�Z�[�W��ǉ����邱�Ƃ��o����z��B
- `deferreds`: Deferred �I�u�W�F�N�g�̔z��B`deferreds.add(callback)` ���g���āA�V���� deferrd �Ȍ��؂�ǉ����邱�Ƃ��o���܂��B

�n���h�����^�U�l `false` ��Ԃ��ƁA�w�肳�ꂽ�����̌��؂͒��~����܂��B
���̌��ʁA`afterValidateAttribute` �C�x���g���g���K�[����܂���B

### `afterValidateAttribute`

`afterValidateAttribute` �C�x���g�́A�t�H�[���S�̂���ъe�����̌��؂̌�Ƀg���K�[����܂��B

�C�x���g�n���h���̃V�O�j�`���͈ȉ��̒ʂ�:

```javascript
function (event, attribute, messages)
```

�����͈ȉ��̒ʂ�:

- `event`: �C�x���g�̃I�u�W�F�N�g�B
- `attribute`: ���؂���鑮���B���̈����̍\���ɂ��Ă� `attributeDefaults` ���Q�Ƃ��ĉ������B
- `messages`: �w�肳�ꂽ�����ɑ΂���ǉ��̌��؃G���[���b�Z�[�W��ǉ����邱�Ƃ��o����z��B

### `beforeSubmit`

`beforeSubmit` �C�x���g�́A�S�Ă̌��؂��ʂ�����A�t�H�[���𑗐M����O�Ƀg���K�[����܂��B

�C�x���g�n���h���̃V�O�j�`���͈ȉ��̒ʂ�:

```javascript
function (event)
```

�����͈ȉ��̒ʂ�:

- `event`: �C�x���g�̃I�u�W�F�N�g�B

�n���h�����^�U�l `false` ��Ԃ��ƁA�t�H�[���̑��M�͒��~����܂��B

### `ajaxBeforeSend`
         
`ajaxBeforeSend` �C�x���g�́AAJAX �x�[�X�̌��؂̂��߂� AJAX ���N�G�X�g�𑗐M����O�Ƀg���K�[����܂��B

�C�x���g�n���h���̃V�O�j�`���͈ȉ��̒ʂ�:

```javascript
function (event, jqXHR, settings)
```

�����͈ȉ��̒ʂ�:

- `event`: �C�x���g�̃I�u�W�F�N�g�B
- `jqXHR`: jqXHR �̃I�u�W�F�N�g�B
- `settings`: AJAX ���N�G�X�g�̐ݒ�B

### `ajaxComplete`

`ajaxComplete` �C�x���g��AJAX �x�[�X�̌��؂̂��߂� AJAX ���N�G�X�g������������Ƀg���K�[����܂��B

�C�x���g�n���h���̃V�O�j�`���͈ȉ��̒ʂ�:

```javascript
function (event, jqXHR, textStatus)
```

�����͈ȉ��̒ʂ�:

- `event`: �C�x���g�̃I�u�W�F�N�g�B
- `jqXHR`: jqXHR �̃I�u�W�F�N�g�B
- `textStatus`: ���N�G�X�g�̏�� ("success", "notmodified", "error", "timeout",
"abort", �܂��� "parsererror")�B

## AJAX �Ńt�H�[���𑗐M����

����(�o���f�[�V����)�́A�N���C�A���g�T�C�h�܂��� AJAX ���N�G�X�g�ɂ���čs�����Ƃ��o���܂����A
�t�H�[���̑��M���̂��̂̓f�t�H���g�ł͒ʏ�̃��N�G�X�g�Ƃ��Ď��s����܂��B
�t�H�[���� AJAX �ő��M�������ꍇ�́A���̂悤�ɁA�t�H�[���� `beforeSubmit` �C�x���g���������邱�Ƃɂ���ĒB�����邱�Ƃ��o���܂��B

```javascript
var $form = $('#formId');
$form.on('beforeSubmit', function() {
    var data = $form.serialize();
    $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: data,
        success: function (data) {
            // ���������Ƃ��̎���
        },
        error: function(jqXHR, errMsg) {
            alert(errMsg);
        }
     });
     return false; // �f�t�H���g�̑��M��}�~
});
```

jQuery �� `ajax()` �֐��ɂ��čX�Ɋw�K���邽�߂ɂ́A[jQuery documentation](https://api.jquery.com/jQuery.ajax/) ���Q�Ƃ��ĉ������B


## �t�B�[���h�𓮓I�ɒǉ�����

���݂̃E�F�u�E�A�v���P�[�V�����ł́A���[�U�ɑ΂��ĕ\��������Ńt�H�[����ύX����K�v������ꍇ���悭����܂��B
�Ⴆ�΁A"�ǉ�"�A�C�R�����N���b�N����ƃt�B�[���h���ǉ������ꍇ�Ȃǂł��B
���̂悤�ȃt�B�[���h�ɑ΂���N���C�A���g�E�o���f�[�V������L���ɂ��邽�߂ɂ́A�t�B�[���h�� ActiveForm JavaScript �v���O�C���ɓo�^���Ȃ���΂Ȃ�܂���B

�t�B�[���h���̂��̂�ǉ����āA�����āA�o���f�[�V�����̃��X�g�ɒǉ����Ȃ���΂Ȃ�܂���B

```javascript
$('#contact-form').yiiActiveForm('add', {
    id: 'address',
    name: 'address',
    container: '.field-address',
    input: '#address',
    error: '.help-block',
    validate:  function (attribute, value, messages, deferred, $form) {
        yii.validation.required(value, messages, {message: "Validation Message Here"});
    }
});
```

�t�B�[���h���o���f�[�V�����̃��X�g����폜���Č��؂���Ȃ��悤�ɂ��邽�߂ɂ́A���̂悤�ɂ��܂��B

```javascript
$('#contact-form').yiiActiveForm('remove', 'address');
```
