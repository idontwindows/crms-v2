<?php
$this->registerJsFile('/js/sweetalert.min.js', ['position' => \yii\web\View::POS_END]);
?>
<script>
    $(document).ready(function() {
        swal("", "There is no functional units to be evaluated please create one by logging in your agency account.", "warning")
            .then((value) => {
                location.replace(frontendURI);
            });
    });
</script>