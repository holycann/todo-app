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
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/font-awesome-6.7.2.css" />
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/flowbite.min.css" />
    <script src="<?= ASSETS_URL ?>/js/sweetalert2@11.js"></script>
    <script src="<?= ASSETS_URL ?>/js/jquery-3.6.0.min.js"></script>
    <script src="<?= ASSETS_URL ?>/js/jquery.validate.min.js"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "ml-2 p-2 flex items-center justify-center text-white font-bold bg-danger-300 transition-all rounded-lg",
                cancelButton: "ml-2 p-2 flex items-center justify-center text-black font-bold bg-gray-300 hover:bg-gray-500 transition-all rounded-lg"
            },
            buttonsStyling: false
        });
    </script>
</head>

<body>
    <div class="w-full layout-wrapper active">
        <div class="w-full flex relative">
            <?php include __DIR__ . '/../components/side_nav.php' ?>
            <div class="body-wrapper dark:bg-darkblack-500 flex-1 overflow-x-hidden">
                <?php include __DIR__ . '/../components/navbar.php' ?>
                <main class="w-full xl:px-12 px-6 pb-6 xl:pb-12 sm:pt-[156px] pt-[100px]">
                    <div class="2xl:flex 2xl:space-x-[48px]">
                        <section class="w-full 2xl:mb-0 mb-6">