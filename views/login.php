<?php
    use \app\core\form\Form;
/** @var $model \app\models\LoginForm */


?>

<h1>Login</h1>

<?php $form = Form::begin() ?>
    <?php echo $form->inputField($formModel, "email") ?>
    <?php echo $form->inputField($formModel, "password")->setType("password") ?>

    <button type="submit" class="btn btn-primary my-2">Submit</button>
<?php Form::end() ?>