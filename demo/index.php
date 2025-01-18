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
                    <h4 style="margin-bottom: 40px; margin-top: 40px;">Local States Nepal Demo</h4>
                    <div class="form-group">
                        <label>Language</label>
                        <select class="form-control language">
                            <option value="en" selected>English</option>
                            <option value="np">नेपाली</option>
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
    $(document).ready(function () {
        // Utility function to clear dependent dropdowns
        function clearDropdowns(...selectors) {
            selectors.forEach(selector => $(selector).find("option:gt(0)").remove());
        }

        // Utility function to populate a dropdown
        function populateDropdown(selector, data) {
            const select = $(selector);
            $.each(data, function (key, value) {
                select.append(`<option value="${key}">${value}</option>`);
            });
        }

        // Function to fetch data and populate a dropdown
        function fetchAndPopulate(url, targetSelector, dependentSelectors = []) {
            clearDropdowns(...dependentSelectors);

            $.ajax({
                url,
                type: 'GET',
                dataType: 'json',
            })
            .done(data => populateDropdown(targetSelector, data))
            .fail(() => console.error(`Failed to fetch data from ${url}`));
        }

        // Reload provinces based on the selected language
        function reloadProvinces(lang) {
            const url = `api/provinces.php?lang=${lang}`;
            fetchAndPopulate(url, '.province', ['.province', '.district', '.municipality', '.ward']);
        }

        // Event handlers
        const langSelector = '.language';
        const provinceSelector = '.province';
        const districtSelector = '.district';
        const municipalitySelector = '.municipality';
        const wardSelector = '.ward';

        $(langSelector).on('change', function () {
            const lang = $(langSelector).val();
            reloadProvinces(lang);
        });

        $(provinceSelector).on('change', function () {
            const lang = $(langSelector).val();
            const provinceId = $(this).val();
            const url = `api/districts.php?lang=${lang}&province_id=${provinceId}`;
            fetchAndPopulate(url, districtSelector, [districtSelector, municipalitySelector, wardSelector]);
        });

        $(districtSelector).on('change', function () {
            const lang = $(langSelector).val();
            const districtId = $(this).val();
            const url = `api/municipalities.php?lang=${lang}&district_id=${districtId}`;
            fetchAndPopulate(url, municipalitySelector, [municipalitySelector, wardSelector]);
        });

        $(municipalitySelector).on('change', function () {
            const lang = $(langSelector).val();
            const municipalityId = $(this).val();
            const url = `api/wards.php?lang=${lang}&municipality_id=${municipalityId}`;
            fetchAndPopulate(url, wardSelector, [wardSelector]);
        });

        // Initial setup
        const initialLang = $(langSelector).val();
        reloadProvinces(initialLang);
    });
</script>


</body>
</html>