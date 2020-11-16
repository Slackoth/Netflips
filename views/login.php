<?php
    use \app\core\form\Form;
/** @var $model \app\models\LoginForm */


?>

<h1>Login</h1>
<?php $form = Form::begin() ?>

    <?php echo $form->inputField($formModel, "email") ?>
    <?php echo $form->inputField($formModel, "password")->setType("password") ?>
    <?php if (isset($_SESSION['errors'])): ?>
    <div class="form-errors alert alert-danger">
        <?php foreach($_SESSION['errors'] as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <button type="submit" class="btn btn-primary my-2">Log In</button>
    <a href="/register">No tienes una cuenta? Registrate</a>
<?php Form::end() ?>