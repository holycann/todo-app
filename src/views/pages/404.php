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

    <section class="dark:bg-notfound-dark bg-no-repeat bg-cover bg-notfound-light">
        <div class="flex items-center justify-center min-h-screen">
            <div class="max-w-2xl mx-auto">
                <img src="<?= ASSETS_URL ?>/images/illustration/404.svg" alt="" />
                <div class="flex justify-center mt-10">
                    <a href="javascript:history.back();"
                        class="bg-success-300 text-sm font-bold text-white rounded-lg px-10 py-3">Go
                        Back</a>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= ASSETS_URL ?>/js/aos.js"></script>
    <script src="<?= ASSETS_URL ?>/js/slick.min.js"></script>

    <script>
        AOS.init();
    </script>

    <script src="<?= ASSETS_URL ?>/js/main.js"></script>

</body>

</html>