<?php
$pageTitle = 'Register';
require __DIR__ . '/../layouts/auth_header.php';
?>
<div class="container-xl px-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <!-- Basic registration form-->
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header justify-content-center"><h3 class="fw-light my-4">Create Account</h3></div>
                <div class="card-body">
                    <?php if ($error = Session::flash('error')): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <?php $errors = Session::flash('errors') ?? []; ?>

                    <!-- Registration form-->
                    <form method="POST" action="<?= base_url('register.php') ?>">
                        <?= CSRF::field() ?>

                        <div class="row gx-3">
                            <div class="col-md-6">
                                <!-- Form Group (full name)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputFullName">Full Name</label>
                                    <input class="form-control <?= isset($errors['full_name']) ? 'is-invalid' : '' ?>" name="full_name" id="inputFullName" type="text" placeholder="Enter full name" value="<?= old('full_name') ?>" />
                                    <?php if (isset($errors['full_name'])): ?>
                                        <div class="invalid-feedback"><?= $errors['full_name'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Form Group (phone)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputPhone">Phone (Optional)</label>
                                    <input class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" name="phone" id="inputPhone" type="text" placeholder="Enter phone number" value="<?= old('phone') ?>" />
                                    <?php if (isset($errors['phone'])): ?>
                                        <div class="invalid-feedback"><?= $errors['phone'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Form Group (email address) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                            <input class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" id="inputEmailAddress" type="email" placeholder="Enter email address" value="<?= old('email') ?>" />
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Form Row -->
                        <div class="row gx-3">
                            <div class="col-md-6">
                                <!-- Form Group (password)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputPassword">Password</label>
                                    <input class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" id="inputPassword" type="password" placeholder="Enter password" />
                                    <?php if (isset($errors['password'])): ?>
                                        <div class="invalid-feedback"><?= $errors['password'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Form Group (confirm password)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                                    <input class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>" name="confirm_password" id="inputConfirmPassword" type="password" placeholder="Confirm password" />
                                    <?php if (isset($errors['confirm_password'])): ?>
                                        <div class="invalid-feedback"><?= $errors['confirm_password'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Form Group (create account submit)-->
                        <button class="btn btn-primary btn-block w-100 mt-3" type="submit">Create Account</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <div class="small"><a href="<?= base_url('login.php') ?>">Have an account? Go to login</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
clear_old();
require __DIR__ . '/../layouts/auth_footer.php';
?>
