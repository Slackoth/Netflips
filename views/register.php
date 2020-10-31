<?php use app\core\form\Form; ?>
<h1>Registrar cuenta</h1>
<?php $form = Form::begin(); ?>
    <div class="row">
        <div class="col">
            <?php echo $form->inputField($formModel, "firstname"); ?>
        </div>
        <div class="col">
            <?php echo $form->inputField($formModel, "lastname"); ?>
        </div>
    </div>
    <?php echo $form->inputField($formModel, "email") ?>
    <?php //echo $form->inputField($formModel, "country") ?>
    <?php echo $form->inputField($formModel, "password")->setType("password") ?>
    <?php echo $form->inputField($formModel, "confirmPassword")->setType("password") ?>
    <?= $form->selectBirthdateField($formModel, "birthdate") ?> 
    <button type="submit" class="btn btn-primary">Submit</button>
<?= Form::end(); ?>
<script src="/assets/js/register.js"></script>