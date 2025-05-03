<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <!-- Favicon -->
        <link rel="icon" href="{{ asset('back-end/assets/images/pesona_desa2.png') }}" type="image/png">
        <title>{{$title}}</title>
        <!-- Simple bar CSS -->
        <link rel="stylesheet" href="{{asset('back-end/css/simplebar.css')}}" />
        <!-- Fonts CSS -->
        <link
            href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet"
        />
        <!-- Icons CSS -->
        <link rel="stylesheet" href="{{asset('back-end/css/feather.css')}}" />
        <link rel="stylesheet" href="{{asset('back-end/css/select2.css')}}" />
        <link rel="stylesheet" href="{{asset('back-end/css/dropzone.css')}}" />
        <link rel="stylesheet" href="{{asset('back-end/css/uppy.min.css')}}" />
        <link rel="stylesheet" href="{{asset('back-end/css/jquery.steps.css')}}" />
        <link rel="stylesheet" href="{{asset('back-end/css/jquery.timepicker.css')}}" />
        <link rel="stylesheet" href="{{asset('back-end/css/quill.snow.css')}}" />
        <!-- Date Range Picker CSS -->
        <link rel="stylesheet" href="{{asset('back-end/css/daterangepicker.css')}}" />
        <!-- App CSS -->
        <link rel="stylesheet" href="{{asset('back-end/css/app-light.css')}}" id="lightTheme" />
        <link
            rel="stylesheet"
            href="{{asset('back-end/css/app-dark.css')}}"
            id="darkTheme"
            disabled
        />

        {{-- Alert --}}
        <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        {{-- Font Awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    </head>
    <body class="vertical light" id="body">

        {{-- Content --}}
        <div class="wrapper">

            {{-- Navbar --}}
            @yield('navbar')
            @yield('sidebar')
            @yield('content')

        </div>

        <!-- .wrapper -->
        <script src="{{asset('back-end/js/jquery.min.js')}}"></script>
        <script src="{{asset('back-end/js/popper.min.js')}}"></script>
        <script src="{{asset('back-end/js/moment.min.js')}}"></script>
        <script src="{{asset('back-end/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('back-end/js/simplebar.min.js')}}"></script>
        <script src="{{asset('back-end/js/daterangepicker.js')}}"></script>
        <script src="{{asset('back-end/js/jquery.stickOnScroll.js')}}"></script>
        <script src="{{asset('back-end/js/tinycolor-min.js')}}"></script>
        <script src="{{asset('back-end/js/config.js')}}"></script>
        <script src="{{asset('back-end/js/d3.min.js')}}"></script>
        <script src="{{asset('back-end/js/topojson.min.js')}}"></script>
        <script src="{{asset('back-end/js/datamaps.all.min.js')}}"></script>
        <script src="{{asset('back-end/js/datamaps-zoomto.js')}}"></script>
        <script src="{{asset('back-end/js/datamaps.custom.js')}}"></script>
        <script src="{{asset('back-end/js/Chart.min.js')}}"></script>
        <script>
            /* defind global options */
            Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
            Chart.defaults.global.defaultFontColor = colors.mutedColor;
        </script>
        <script src="{{asset('back-end/js/gauge.min.js')}}"></script>
        <script src="{{asset('back-end/js/jquery.sparkline.min.js')}}"></script>
        <script src="{{asset('back-end/js/apexcharts.min.js')}}"></script>
        <script src="{{asset('back-end/js/apexcharts.custom.js')}}"></script>
        <script src="{{asset('back-end/js/jquery.mask.min.js')}}"></script>
        <script src="{{asset('back-end/js/select2.min.js')}}"></script>
        <script src="{{asset('back-end/js/jquery.steps.min.js')}}"></script>
        <script src="{{asset('back-end/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('back-end/js/jquery.timepicker.js')}}"></script>
        <script src="{{asset('back-end/js/dropzone.min.js')}}"></script>
        <script src="{{asset('back-end/js/uppy.min.js')}}"></script>
        <script src="{{asset('back-end/js/quill.min.js')}}"></script>

        {{-- Alert --}}
        <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

        <!-- Bootstrap Bundle (termasuk Popper.js) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        {{-- Script untuk Light/Dark Mode --}}
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const modeSwitcher = document.getElementById("modeSwitcher");
                const lightTheme = document.getElementById("lightTheme");
                const darkTheme = document.getElementById("darkTheme");

                // Cek theme tersimpan
                const savedTheme = localStorage.getItem("theme");
                if (savedTheme === "dark") {
                    lightTheme.disabled = true;
                    darkTheme.disabled = false;
                    modeSwitcher.dataset.mode = "dark";
                    modeSwitcher.innerHTML = '<i class="fe fe-moon fe-16"></i>';
                }

                modeSwitcher.addEventListener("click", function (e) {
                    e.preventDefault(); // hindari reload karena href kosong

                    const currentMode = modeSwitcher.dataset.mode;

                    if (currentMode === "light") {
                        lightTheme.disabled = true;
                        darkTheme.disabled = false;
                        localStorage.setItem("theme", "dark");
                        modeSwitcher.dataset.mode = "dark";
                        modeSwitcher.innerHTML = '<i class="fe fe-moon fe-16"></i>';
                    } else {
                        lightTheme.disabled = false;
                        darkTheme.disabled = true;
                        localStorage.setItem("theme", "light");
                        modeSwitcher.dataset.mode = "light";
                        modeSwitcher.innerHTML = '<i class="fe fe-sun fe-16"></i>';
                    }
                });
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.querySelector('input[placeholder="Search"]'); // Input pencarian
            const tableBody = document.querySelector('tbody'); // Body tabel
            const tableRows = tableBody.querySelectorAll('tr'); // Semua baris tabel

            // Buat elemen peringatan dalam bentuk baris tabel
            const noDataRow = document.createElement('tr');
            noDataRow.innerHTML = `
                <td colspan="8" class="text-center text-muted">
                    <i class="fe fe-alert-circle"></i> Tidak ada data yang ditemukan.
                </td>
            `;
            noDataRow.style.display = 'none'; // Awalnya disembunyikan
            tableBody.appendChild(noDataRow); // Tambahkan ke dalam <tbody>

            // Event listener untuk input pencarian
            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                let visibleRows = 0; // Hitung jumlah baris yang masih terlihat

                tableRows.forEach(row => {
                    const cells = Array.from(row.querySelectorAll('td'));
                    const rowText = cells.map(cell => cell.textContent.toLowerCase()).join(' ');
                    if (rowText.includes(searchTerm)) {
                        row.style.display = ''; // Tampilkan baris jika cocok
                        visibleRows++;
                    } else {
                        row.style.display = 'none'; // Sembunyikan baris jika tidak cocok
                    }
                });

                // Jika tidak ada baris yang cocok, tampilkan peringatan
                if (visibleRows === 0) {
                    noDataRow.style.display = '';
                } else {
                    noDataRow.style.display = 'none';
                }
            });
        });
        </script>

        <script>
            $(".select2").select2({
                theme: "bootstrap4",
            });
            $(".select2-multi").select2({
                multiple: true,
                theme: "bootstrap4",
            });
            $(".drgpicker").daterangepicker({
                singleDatePicker: true,
                timePicker: false,
                showDropdowns: true,
                locale: {
                    format: "MM/DD/YYYY",
                },
            });
            $(".time-input").timepicker({
                scrollDefault: "now",
                zindex: "9999" /* fix modal open */,
            });
            /** date range picker */
            if ($(".datetimes").length) {
                $(".datetimes").daterangepicker({
                    timePicker: true,
                    startDate: moment().startOf("hour"),
                    endDate: moment().startOf("hour").add(32, "hour"),
                    locale: {
                        format: "M/DD hh:mm A",
                    },
                });
            }
            var start = moment().subtract(29, "days");
            var end = moment();

            function cb(start, end) {
                $("#reportrange span").html(
                    start.format("MMMM D, YYYY") +
                        " - " +
                        end.format("MMMM D, YYYY")
                );
            }
            $("#reportrange").daterangepicker(
                {
                    startDate: start,
                    endDate: end,
                    ranges: {
                        Today: [moment(), moment()],
                        Yesterday: [
                            moment().subtract(1, "days"),
                            moment().subtract(1, "days"),
                        ],
                        "Last 7 Days": [moment().subtract(6, "days"), moment()],
                        "Last 30 Days": [
                            moment().subtract(29, "days"),
                            moment(),
                        ],
                        "This Month": [
                            moment().startOf("month"),
                            moment().endOf("month"),
                        ],
                        "Last Month": [
                            moment().subtract(1, "month").startOf("month"),
                            moment().subtract(1, "month").endOf("month"),
                        ],
                    },
                },
                cb
            );
            cb(start, end);
            $(".input-placeholder").mask("00/00/0000", {
                placeholder: "__/__/____",
            });
            $(".input-zip").mask("00000-000", {
                placeholder: "____-___",
            });
            $(".input-money").mask("#.##0,00", {
                reverse: true,
            });
            $(".input-phoneus").mask("(000) 000-0000");
            $(".input-mixed").mask("AAA 000-S0S");
            $(".input-ip").mask("0ZZ.0ZZ.0ZZ.0ZZ", {
                translation: {
                    Z: {
                        pattern: /[0-9]/,
                        optional: true,
                    },
                },
                placeholder: "___.___.___.___",
            });
            // editor
            var editor = document.getElementById("editor");
            if (editor) {
                var toolbarOptions = [
                    [
                        {
                            font: [],
                        },
                    ],
                    [
                        {
                            header: [1, 2, 3, 4, 5, 6, false],
                        },
                    ],
                    ["bold", "italic", "underline", "strike"],
                    ["blockquote", "code-block"],
                    [
                        {
                            header: 1,
                        },
                        {
                            header: 2,
                        },
                    ],
                    [
                        {
                            list: "ordered",
                        },
                        {
                            list: "bullet",
                        },
                    ],
                    [
                        {
                            script: "sub",
                        },
                        {
                            script: "super",
                        },
                    ],
                    [
                        {
                            indent: "-1",
                        },
                        {
                            indent: "+1",
                        },
                    ], // outdent/indent
                    [
                        {
                            direction: "rtl",
                        },
                    ], // text direction
                    [
                        {
                            color: [],
                        },
                        {
                            background: [],
                        },
                    ], // dropdown with defaults from theme
                    [
                        {
                            align: [],
                        },
                    ],
                    ["clean"], // remove formatting button
                ];
                var quill = new Quill(editor, {
                    modules: {
                        toolbar: toolbarOptions,
                    },
                    theme: "snow",
                });
            }
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function () {
                "use strict";
                window.addEventListener(
                    "load",
                    function () {
                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                        var forms =
                            document.getElementsByClassName("needs-validation");
                        // Loop over them and prevent submission
                        var validation = Array.prototype.filter.call(
                            forms,
                            function (form) {
                                form.addEventListener(
                                    "submit",
                                    function (event) {
                                        if (form.checkValidity() === false) {
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }
                                        form.classList.add("was-validated");
                                    },
                                    false
                                );
                            }
                        );
                    },
                    false
                );
            })();
        </script>
        <script>
            var uptarg = document.getElementById("drag-drop-area");
            if (uptarg) {
                var uppy = Uppy.Core()
                    .use(Uppy.Dashboard, {
                        inline: true,
                        target: uptarg,
                        proudlyDisplayPoweredByUppy: false,
                        theme: "dark",
                        width: 770,
                        height: 210,
                        plugins: ["Webcam"],
                    })
                    .use(Uppy.Tus, {
                        endpoint: "https://master.tus.io/files/",
                    });
                uppy.on("complete", (result) => {
                    console.log(
                        "Upload complete! We’ve uploaded these files:",
                        result.successful
                    );
                });
            }
        </script>
        <script src="{{asset('back-end/js/apps.js')}}"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script
            async
            src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"
        ></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag("js", new Date());
            gtag("config", "UA-56159088-1");
        </script>

        {{-- ToolTips --}}
        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>


    </body>
</html>
