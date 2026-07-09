<?php
$pageTitle = 'Login';
require __DIR__ . '/../layouts/auth_header.php';
?>
<div class="container-xl px-4">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <!-- Basic login form-->
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header justify-content-center"><h3 class="fw-light my-4">Login</h3></div>
                <div class="card-body">
                    <?php if ($success = Session::flash('success')): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>
                    
                    <?php if ($error = Session::flash('error')): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <?php $errors = Session::flash('errors') ?? []; ?>

                    <!-- Login form-->
                    <form method="POST" action="<?= base_url('login.php') ?>">
                        <?= CSRF::field() ?>
                        
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                            <input class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" id="inputEmailAddress" type="email" placeholder="Enter email address" value="<?= old('email') ?>" />
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Form Group (password)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputPassword">Password</label>
                            <input class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" id="inputPassword" type="password" placeholder="Enter password" />
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= $errors['password'] ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Form Group (remember password checkbox)-->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" name="remember" id="rememberPasswordCheck" type="checkbox" value="1" />
                                <label class="form-check-label" for="rememberPasswordCheck">Remember Me</label>
                            </div>
                        </div>
                        
                        <!-- Form Group (login box)-->
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <a class="small" href="#">Forgot Password?</a>
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <div class="small"><a href="<?= base_url('register.php') ?>">Need an account? Sign up!</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
clear_old();
require __DIR__ . '/../layouts/auth_footer.php';
?>
