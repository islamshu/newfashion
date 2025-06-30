<div class="modal login-modal fade" id="user-login" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">
                                Log In
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="false">Registration</button>
                        </li>
                    </ul>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="login-registration-form">
                                <div class="form-title">
                                    <h3>Log In</h3>
                                </div>
                                <form>
                                    <div class="form-inner mb-35">
                                        <input type="text" placeholder="User name or Email *">
                                    </div>
                                    <div class="form-inner">
                                        <input id="password" type="password" placeholder="Password *">
                                        <i class="bi bi-eye-slash" id="togglePassword"></i>
                                    </div>
                                    <div class="form-remember-forget">
                                        <div class="remember">
                                            <input type="checkbox" class="custom-check-box" id="check1">
                                            <label for="check1">Remember me</label>
                                        </div>
                                        <a href="#" class="forget-pass hover-underline">Forget Password</a>
                                    </div>
                                    <a href="#" class="primary-btn1 hover-btn3">Log In</a>
                                    <a href="#" class="member">Not a member yet?</a>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="login-registration-form">
                                <div class="form-title">
                                    <h3>Registration</h3>
                                </div>
                                <form>
                                    <div class="form-inner mb-25">
                                        <input type="text" placeholder="User Name *">
                                    </div>
                                    <div class="form-inner mb-25">
                                        <input type="email" placeholder="Email Here *">
                                    </div>
                                    <div class="form-inner mb-25">
                                        <input id="password2" type="password" placeholder="Password *">
                                        <i class="bi bi-eye-slash" id="togglePassword2"></i>
                                    </div>
                                    <div class="form-inner mb-35">
                                        <input id="password3" type="password" placeholder="Confirm Password *">
                                        <i class="bi bi-eye-slash" id="togglePassword3"></i>
                                    </div>
                                    <a href="#" class="primary-btn1 hover-btn3">Registration</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>