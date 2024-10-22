<?php
include("includes/head.php");
?>

<script src="<?php echo RUTAGENERAL; ?>/templates/vendor/jquery/jquery.min.js"></script>

<script>
    function f_mensaje() {
        $('.toast').toast('show');
    }

    $(document).ready(function() {
        <?php
        if (isset($_SESSION['login']) && $_SESSION['login']) {
        ?>
            f_mensaje();
            <?php unset($_SESSION['login']); ?>
        <?php
        }
        ?>
    });
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
        <div id="liveToast" class="toast hide overflow-hidden" style="border-radius: 0.5rem;" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
            <div class="toast-header">
                <strong class="mr-auto">Mensaje del sistema:</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body bg-success text-white">
                <i class="fas fa-check-circle"></i> <?php echo $_SESSION['mensaje']; ?>
            </div>
        </div>
    </div>

    <!-- Inicio de la zona central del sistema -->
    <!-- Todo -->


    <!-- Fin  de la zona central del sistema -->
</div>
<!-- /.container-fluid -->
<?php
include("includes/food.php");
?>