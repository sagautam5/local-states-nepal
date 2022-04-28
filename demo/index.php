<html>
<head>
    <title>Local State Nepal Demo</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    
</head>
<body>
    <section class="demo-form">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="side-image">
                        <!-- <h3>Local States Nepal</h3>
                        <p>Local state nepal. 
                        </p> -->
                        <img src="./assets/images/nepal-map.png" alt="">
                    </div>
                    
                </div>
                <div class="col-md-6"> 
                    <div class="bg-form">
                    <h4 style="margin-bottom: 40px; margin-top: 40px;">Local State Nepal Demo</h4>
                    <div class="form-group">
                        <label>Language</label>
                        <select class="form-control language">
                            <option value="en" selected>English</option>
                            <option value="np">Nepali</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Province</label>
                        <select class="form-control province">
                            <option>Select</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>District</label>
                        <select class="form-control district">
                            <option>Select</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Municipality</label>
                        <select class="form-control municipality">
                            <option>Select</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ward</label>
                        <select class="form-control ward">
                            <option>Select</option>
                        </select>
                    </div>
                    </div>           
                </div>
            </div>
        </div>
    </section>


<!-- Latest compiled and minified JavaScript -->
<script src="./assets/js/jquery.min.js"></script>
<script src="./assets/js/jquery-ui.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>

<!-- Current doc JS -->
<script type="text/javascript">
    function reloadProvinces(lang)
    {
        $('.province').find("option:gt(0)").remove();
        $('.district').find("option:gt(0)").remove();
        $('.municipality').find("option:gt(0)").remove();
        $('.ward').find("option:gt(0)").remove();

        $.ajax({
            url: '/local-states-nepal/demo/api/provinces.php?lang='+lang,
            type: 'GET',
            dataType: 'json',
        }).done(function (data) {
            var select = $('.province');
            $.each(data, function (key, value) {
                select.append('<option value=' + key + '>' + value + '</option>');
            });
        });
    }
    $(document).ready(function (){
        var lang = $('.language').val();
        reloadProvinces(lang);
        $('.language').on('change', function (){
            lang = $('.language').val();
            reloadProvinces(lang);
        });

        $('.province').on('change', function () {
            $('.district').find("option:gt(0)").remove();
            $('.municipality').find("option:gt(0)").remove();
            $('.ward').find("option:gt(0)").remove();
            var selected = $(this).find(":selected").attr('value');
            $.ajax({
                url: '/local-states-nepal/demo/api/districts.php?lang='+lang+'&&province_id=' + selected,
                type: 'GET',
                dataType: 'json',
            }).done(function (data) {
                var select = $('.district');
                $.each(data, function (key, value) {
                    select.append('<option value=' + key + '>' + value + '</option>');
                });
            })
        });

        $('.district').on('change', function () {
            $('.municipality').find("option:gt(0)").remove();
            $('.ward').find("option:gt(0)").remove();
            var selected = $(this).find(":selected").attr('value');
            $.ajax({
                url: '/local-states-nepal/demo/api/municipalities.php?lang='+lang+'&&district_id=' + selected,
                type: 'GET',
                dataType: 'json',
            }).done(function (data) {
                var select = $('.municipality');
                $.each(data, function (key, value) {
                    select.append('<option value=' + key + '>' + value + '</option>');
                });
            })
        });

        $('.municipality').on('change', function () {
            var selected = $(this).find(":selected").attr('value');
            $('.ward').find("option:gt(0)").remove();
            $.ajax({
                url: '/local-states-nepal/demo/api/wards.php?lang='+lang+'&&municipality_id=' + selected,
                type: 'GET',
                dataType: 'json',
            }).done(function (data) {
                var select = $('.ward');
                $.each(data, function (key, value) {
                    select.append('<option value=' + key + '>' + value + '</option>');
                });
            })
        });
    });
</script>
</body>
</html>