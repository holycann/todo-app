<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'To-Do App'; ?></title>

    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/slick.css" />
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/aos.css" />
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/output.css" />
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/style.css" />
    <script src="<?= ASSETS_URL ?>/js/sweetalert2@11.js"></script>
    <script src="<?= ASSETS_URL ?>/js/jquery-3.6.0.min.js"></script>
    <script src="<?= ASSETS_URL ?>/js/jquery.validate.min.js"></script>
</head>

<body>
    <section class="bg-white dark:bg-darkblack-500">
        <div class="flex flex-col lg:flex-row justify-between min-h-screen">
            <!-- Left -->
            <div class="lg:w-1/2 px-5 xl:pl-12 pt-10">
                <header>
                    <a href="" class="">
                        <img src="<?= ASSETS_URL ?>/images/logo/logo-text.png" class="block dark:hidden" alt="Logo"
                            width="100" height="100" />
                    </a>
                </header>
                <div class="max-w-[450px] m-auto pt-24 pb-16">
                    <header class="text-center mb-8">
                        <h2 class="text-bgray-900 dark:text-white text-4xl font-semibold font-poppins mb-2">
                            Sign in
                        </h2>
                        <p class="font-urbanis text-base font-medium text-bgray-600 dark:text-bgray-50">
                            Plan, Prioritize, and Complete Smarter
                        </p>
                    </header>

                    <form action="<?= BASE_ENDPOINT ?>/login" method="POST" id="LoginForm">
                        <div class="mb-4">
                            <input type="email" name="email"
                                class="text-bgray-800 text-base border border-bgray-300 dark:border-darkblack-400 dark:bg-darkblack-500 dark:text-white h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base"
                                placeholder="Email" required />
                        </div>
                        <div class="mb-6 relative">
                            <input type="password" name="password" id="password"
                                class="text-bgray-800 text-base border border-bgray-300 dark:border-darkblack-400 dark:bg-darkblack-500 dark:text-white h-14 w-full focus:border-success-300 focus:ring-0 rounded-lg px-4 py-3.5 placeholder:text-bgray-500 placeholder:text-base"
                                placeholder="Password" required />
                            <button class="absolute top-4 right-4 bottom-4" onclick="showHidePassword()" type="button">
                                <svg width="22" height="20" viewBox="0 0 22 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 1L20 19" stroke="#718096" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M9.58445 8.58704C9.20917 8.96205 8.99823 9.47079 8.99805 10.0013C8.99786 10.5319 9.20844 11.0408 9.58345 11.416C9.95847 11.7913 10.4672 12.0023 10.9977 12.0024C11.5283 12.0026 12.0372 11.7921 12.4125 11.417"
                                        stroke="#718096" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M8.363 3.36506C9.22042 3.11978 10.1082 2.9969 11 3.00006C15 3.00006 18.333 5.33306 21 10.0001C20.222 11.3611 19.388 12.5241 18.497 13.4881M16.357 15.3491C14.726 16.4491 12.942 17.0001 11 17.0001C7 17.0001 3.667 14.6671 1 10.0001C2.369 7.60506 3.913 5.82506 5.632 4.65906"
                                        stroke="#718096" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-between mb-7">
                            <div class="flex items-center space-x-3">
                                <input type="checkbox"
                                    class="w-5 h-5 dark:bg-darkblack-500 focus:ring-transparent rounded-full border border-bgray-300 focus:accent-success-300 text-success-300"
                                    name="remember" id="remember" />
                                <label for="remember"
                                    class="text-bgray-900 dark:text-white text-base font-semibold">Remember me</label>
                            </div>
                        </div>
                        <button type="submit"
                            class="py-3.5 flex items-center justify-center text-white font-bold bg-success-300 hover:bg-success-400 transition-all rounded-lg w-full">
                            Sign In
                        </button>
                    </form>
                    <p class="text-center text-bgray-900 dark:text-bgray-50 text-base font-medium pt-7">
                        Don’t have an account?
                        <a href="register" class="font-semibold underline">Sign Up</a>
                    </p>
                </div>
            </div>
            <!-- Right -->
            <div class="lg:w-1/2 lg:block hidden bg-[#F6FAFF] dark:bg-darkblack-600 p-20 relative">
                <ul>
                    <li class="absolute top-10 left-8">
                        <img src="<?= ASSETS_URL ?>/images/shapes/square.svg" alt="" />
                    </li>
                    <li class="absolute right-12 top-14">
                        <img src="<?= ASSETS_URL ?>/images/shapes/vline.svg" alt="" />
                    </li>
                    <li class="absolute bottom-7 left-8">
                        <img src="<?= ASSETS_URL ?>/images/shapes/dotted.svg" alt="" />
                    </li>
                </ul>
                <div class="">
                    <img src="<?= ASSETS_URL ?>/images/illustration/signin.svg" alt="" />
                </div>
                <div>
                    <div class="text-center max-w-lg px-1.5 m-auto">
                        <h3 class="text-bgray-900 dark:text-white font-semibold font-popins text-4xl mb-4">
                            Simple, Fast, and Efficient
                        </h3>
                        <p class="text-bgray-600 dark:text-bgray-50 text-sm font-medium">
                            Helping you stay organized, manage tasks effortlessly, and boost productivity. Get
                            reminders,
                            collaborate with others, and track your progress all in one place.
                            <br>
                            <span class="text-success-300 font-bold">Sign in today and start getting things done!</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            $("#LoginForm").validate({
                rules: {
                    email: {
                        required: true,
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    email: {
                        required: "Email is required."
                    },
                    password: {
                        required: "Password is required."
                    },
                },
                errorElement: "span",
                errorClass: "error",
                submitHandler: async function (form) {
                    event.preventDefault();

                    const Toast = await Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });

                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        dataType: "json",
                        success: async function (response) {
                            await Toast.fire({
                                icon: "success",
                                title: response.message || "Login successfully"
                            }).then(() => {
                                window.location.href = "<?= BASE_ENDPOINT ?>/";
                            });
                        },
                        error: function (xhr) {
                            let message;
                            if (xhr.responseText.includes('Fatal error')) {
                                const match = xhr.responseText.match(/Uncaught(.*?) in/s);

                                message = match ? match[1].trim() : "Unknown error";
                            }

                            Swal.fire({
                                icon: "error",
                                title: "Registration Failed",
                                text: xhr.responseJSON?.error || message || "Something went wrong.",
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });
        });

        function showHidePassword() {
            let passwordField = document.getElementById("password");

            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>

    <script src="<?= ASSETS_URL ?>/js/aos.js"></script>
    <script src="<?= ASSETS_URL ?>/js/slick.min.js"></script>

    <script>
        AOS.init();
    </script>

    <script src="<?= ASSETS_URL ?>/js/main.js"></script>

</body>

</html>