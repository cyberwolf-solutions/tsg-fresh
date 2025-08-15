<div id="loginModal"
    style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9998; display: none; justify-content: center; align-items: center;">



    <div
        style="background-color: white; width: 500px; padding: 20px; border-radius: 5px; box-shadow: 0 0 20px rgba(0,0,0,0.2); display: flex; justify-content: space-between;">
        <div style="width: 45%;">
            <h2 style="font-size: 24px; font-weight: bold; color: #333;">LOGIN</h2>

            <form method="POST" action="{{ route('customer.login.post') }}">
                @csrf <!-- Laravel CSRF token -->

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">
                        Username or email address *
                    </label>
                    <input type="text" name="email" value="nipun.sankalana@gmail.com"
                        style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; background-color: #e6f3ff;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Password
                        *</label>
                    <input type="password" name="password" value="********"
                        style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; background-color: #e6f3ff;">
                </div>

                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <input type="checkbox" name="remember" id="remember" style="margin-right: 5px;">
                        <label for="remember" style="color: #555; margin-right: 10px;">Remember me</label>
                    </div>
                    <a href="#" style="color: #0078ce; text-decoration: none; font-size: 12px;">Lost your
                        password?</a>
                </div>

                <button type="submit"
                    style="width: 100%; padding: 10px; background-color: #0078ce; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                    LOG IN
                </button>
            </form>

        </div>
        <div style="width: 45%; padding-left: 20px; border-left: 1px solid #ddd;">
            <h2 style="font-size: 24px; font-weight: bold; color: #333;">REGISTER</h2>

            @if ($errors->any())
                <div style="color: red; margin-bottom: 15px;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('customer.register.post') }}">
                @csrf

                <div style="margin-bottom: 15px;">
                    <label for="register-email"
                        style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">
                        Email address *
                    </label>
                    <input id="register-email" name="email" type="email" required
                        style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="register-password"
                        style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">
                        Password *
                    </label>
                    <input id="register-password" name="password" type="password" required
                        style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <button type="submit"
                    style="width: 100%; padding: 10px; background-color: #0078ce; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                    REGISTER
                </button>
            </form>
        </div>

    </div>
</div>
