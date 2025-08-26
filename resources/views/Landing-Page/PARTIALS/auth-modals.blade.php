<!-- Login/Register Modal -->
<div id="loginModal"
    style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9998; display: none; justify-content: center; align-items: center;">

    <div
        style="background-color: #fff; width: 850px; padding: 30px; border-radius: 4px; box-shadow: 0 0 15px rgba(0,0,0,0.2); display: flex; justify-content: space-between;">

        <!-- LOGIN -->
        <div style="width: 48%; padding-right: 20px; border-right: 1px solid #ddd;">
            <h2 style="font-size: 18px; font-weight: bold; color: #444; margin-bottom: 20px;">LOGIN</h2>

            <form method="POST" action="{{ route('customer.login.post') }}">
                @csrf

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 600; color: #555;">
                        Username or email address *
                    </label>
                    <input type="text" name="email" value="nipun.sankalana@gmail.com"
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; font-size: 14px; border-radius: 2px; background: #f8fbff;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 600; color: #555;">
                        Password *
                    </label>
                    <input type="password" name="password" value="********"
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; font-size: 14px; border-radius: 2px; background: #f8fbff;">
                </div>

                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; font-size: 13px;">
                    <label style="display: flex; align-items: center; color: #555; cursor: pointer;">
                        <input type="checkbox" name="remember" style="margin-right: 6px;"> Remember me
                    </label>

                </div>

                <button type="submit mb-2"
                    style="padding: 10px 20px; background-color: #0073aa; color: #fff; border: none; border-radius: 2px; font-weight: bold; cursor: pointer;">
                    LOG IN
                </button>
                <br>
                <a href="{{ route('customer.forgot-password.form') }}" class="mt-2"
                    style="color: #0073aa; text-decoration: none;">Lost your password?</a>
            </form>
        </div>

        <!-- REGISTER -->
        <div style="width: 48%; padding-left: 20px;">
            <h2 style="font-size: 18px; font-weight: bold; color: #444; margin-bottom: 20px;">REGISTER</h2>

            <form method="POST" action="{{ route('customer.register.post') }}">
                @csrf

                <div style="margin-bottom: 15px;">
                    <label for="register-email"
                        style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 600; color: #555;">
                        Email address *
                    </label>
                    <input id="register-email" name="email" type="email" required
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; font-size: 14px; border-radius: 2px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="register-password"
                        style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 600; color: #555;">
                        Password *
                    </label>
                    <input id="register-password" name="password" type="password" required
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; font-size: 14px; border-radius: 2px;">
                </div>

                <button type="submit"
                    style="padding: 10px 20px; background-color: #0073aa; color: #fff; border: none; border-radius: 2px; font-weight: bold; cursor: pointer;">
                    REGISTER
                </button>
            </form>
        </div>
    </div>
</div>
