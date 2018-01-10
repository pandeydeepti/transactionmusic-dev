var session = {
    set: function( property, value ){
        localStorage.setItem(property, value)
    },
    get: function( property, fallbackValue ){
        return localStorage.getItem(property) != 'undefined' ? localStorage.getItem(property) : fallbackValue;
    }
}

var config = {
    alertify: {
        confirm : 'Confirm',
        ok: 'Yes',
        cancel: 'No',
    },
    uploader: {
        labels: {
            mp3_choose: 'CHOOSE FILE',
            wav_choose: 'CHOOSE FILE',
            tracked_out_choose: 'CHOOSE FILE',
        }
    },
    song_global: '',
    routes: {
        subinstances_sync: "/subinstances/sync",
        activate_category: "/admin/categories/active/"
    },
    messages: {
        please_fill: 'Please fill ',
        rate_range: 'Rate range is from 1 to 100, please type correct rate',
        producers_max: 'Maximum number of producers is ',
        fill_title: this.please_fill + 'category title',
        max_title_chars: 'Maximum number of character in title is ' + this.title_length,
        fill_category_description: this.please_fill + 'category description',
        subinstance_name: this.please_fill + 'subinstance name',
        subinstance_url : this.please_fill + 'subinstance url',
        subinstance_properly_url : this.please_fill + 'properly subinstance url',
        main_color: this.please_fill + 'fill main color',
        secondary_color: this.please_fill + 'fill secondary color',
        third_color: this.please_fill + 'fill third color',
        invalid_paypal: 'You have entered an invalid paypal email address. Please try again',
        invalid_email: 'You have entered an invalid main email address. Please try again',
        fill_email_content: 'Please fill mail text',
        fill_thankyou_content: 'Please fill thank you page',
        fill_email_content: 'Please fill mail text',
        fill_email_content: 'Please fill mail text',
        select_image: 'Please select image',
        delete_producer: 'Are you sure that you want to delete this producer',
        delete_faq: 'Are you sure that you want to delete this faq',
        select_country: 'Please select country'
    },
    max: {
        producers: 3,
        title_length: 22
    }
}

$(document).ready(function ($) {

    /*
     *
     * Variables
     *
     * */
    var editor_config = {
        path_absolute: "/",
        selector: "#page-description, #email_content, #thank_you_page",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern textcolor"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor | fontsizeselect",
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        relative_urls: false,
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        }
    };
    var uploaded_files = [];
    var update_uploaders = 0;
    var uploaders = [];

    /*
     *
     * Init
     *
     * */

    $('.alertify-log').remove();
    tinymce.init(editor_config);
    if(typeof lf != 'undefined' && typeof lf.getSiteUrl != 'undefined'){
        handle_embed_create();
    }
    if (typeof lf != 'undefined' && typeof lf.mp3_choose != 'undefined' && typeof lf.wav_choose != 'undefined' && typeof lf.tracked_out_choose != 'undefined') {
        config.uploader.labels.mp3_choose = lf.mp3_choose;
        config.uploader.labels.wav_choose = lf.wav_choose;
        config.uploader.labels.tracked_out_choose = lf.tracked_out_choose;
    }

    alertify.set({
        labels: {
            ok: config.alertify.ok,
            cancel:  config.alertify.cancel
        }
    });

    if (typeof lf != 'undefined' && typeof lf.type != 'undefined' && lf.type != null && lf.message != '') {
        alertify[lf.type](lf.message);
    }

    $.uploadPreview({
        input_field: "main_banner_image",
        preview_box: "#main_banner"
    });
    $.uploadPreview({
        input_field: "secondary_banner_image",
        preview_box: "#secondary_banner",
    });
    $.uploadPreview({
        input_field: "image-upload",
        preview_box: "#beat-cover"
    });
    $.uploadPreview({
        input_field: "category-upload",
        preview_box: "#category-cover"
    });
    $.uploadPreview({
        input_field: "#mp3input",
        preview_box: "#mp3div"
    });
    $.uploadPreview({
        input_field: "image-upload",
        preview_box: "#shop_logo"
    });
    $.uploadPreview({
        input_field: "image-upload-beat-logo",
        preview_box: "#shop_beat_logo"
    });
    $.uploadPreview({
        input_field: "image-upload-category-logo",
        preview_box: "#shop_category_logo"
    });
    $.uploadPreview({
        input_field: "first_producer_image",
        preview_box: "#first_producer"
    });

    $('#myTable, #categoryTable, #pageTable, #subintanceTable').dataTable({
        language: {
            sSearch: '',
            searchPlaceholder: "Search",
            display: 'stripe',
        },
        ordering: false,
        iDisplayLength: session.get('per_page', 5),
        aLengthMenu: [5, 10, 25, 50, 100]
    }).on('draw.dt', function () {
        $(".a_element").on('click', function (e) {
            e.preventDefault();

            var redirect_url = $(this).attr('href');

            alertify.confirm("Message", function (e) {
                if (e) {
                    window.location.href = redirect_url;
                }
            });

        });
    });

    if (typeof lf != 'undefined' && typeof lf.stats != 'undefined' && lf.stats != null) {

            $('#today_beats').dataTable({
                "dom": 'ftBi',
                ordering: true,
                iDisplayLength: -1,
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ],
                data: lf.today_stats,
                fixedColumns: true,
                scrollY:        "410px",
                columns : [
                    {'data': "bought_times", 'width' : '7%' },
                    {'data': "beat_title", 'width' : null },
                    {'data': "categories", 'width' : null },
                    {'data': "price", 'width' : '7%' },
                    {'data': "types", 'width' : '14%' },
                    {'data': "bpm", 'width' : '6%' },
                    {'data': "created_at", 'width' : '14.5%' }
                ]
            });

        var table_range = $('#date_range_beats').dataTable({
            "dom": 'ftBi',
            ordering: true,
            iDisplayLength: -1,
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            data: lf.stats,
            fixedColumns: true,
            scrollY:        "410px",
            columns : [
                {'data': "bought_times", 'width' : '7%' },
                {'data': "beat_title", 'width' : null },
                {'data': "categories", 'width' : null },
                {'data': "price", 'width' : '7%' },
                {'data': "types", 'width' : '14%' },
                {'data': "bpm", 'width' : '6%' },
                {'data': "created_at", 'width' : '14.5%' },
            ]
        });

        var table_all = $('#all_beats').dataTable({
            "dom": 'ftBi',
            ordering: true,
            iDisplayLength: -1,
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            data: lf.stats,
            fixedColumns: true,
            scrollY:        "410px",
            columns : [
                {'data': "bought_times", 'width' : '7%' },
                {'data': "beat_title", 'width' : null },
                {'data': "categories", 'width' : null },
                {'data': "price", 'width' : '7%' },
                {'data': "types", 'width' : '14%' },
                {'data': "bpm", 'width' : '6%' },
                {'data': "created_at", 'width' : '14.5%' }
            ]
        });
        // Date range filter
        var minDateFilter = "";
        var maxDateFilter = "";

        $('input[name="daterange"]').daterangepicker(
            {
                locale: {
                    format: 'YYYY-MM-DD'
                }
            },
            function(start, end) {
                minDateFilter = new Date(start.format('YYYY/MM/DD')).getTime();
                maxDateFilter = new Date(end.format('YYYY/MM/DD')).getTime();

                table_range.fnDraw();
            });

        $('.nav-tabs a').on('shown.bs.tab', function(event){ 
            table_all.fnDraw();
            table_range.fnDraw();
        });

        $.fn.dataTableExt.afnFiltering.push(
            function(oSettings, aData, iDataIndex) {
                if (typeof aData.created_at == 'undefined') {
                    aData.created_at = new Date(aData[6]).getTime();
                }

                if ((minDateFilter && !isNaN(minDateFilter)) && ( maxDateFilter && !isNaN(maxDateFilter) )) {
                    console.log(aData.created_at > minDateFilter, aData.created_at <= maxDateFilter);
                    if
                    (
                        aData.created_at >= minDateFilter &&
                        aData.created_at <= maxDateFilter
                    ){
                        return true;
                    } else{
                        return false;
                    }
                }

                return true;
            }
        );

    }

    $('.shop_colorpicker').colorpicker({
        customClass: 'colorpicker-2x',
        container: '.color-preview-container',
        format: 'hex',
        sliders: {
            saturation: {
                maxLeft: 200,
                maxTop: 200
            },
            hue: {
                maxTop: 200
            },
            alpha: {
                maxTop: 200
            }
        }
    }).bind('changeColor', function (e) {
        var color = $(e.target).colorpicker('getValue');
        $(e.target).css('background-color', color)
    });
    uploaders.uploader_mp3 = $("#mp3div").lfUploadFile({

        url: '/admin/beats/audio',
        headers: {
            'field': 'mp3',
            'beattitle': config.song_global,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        autoSubmit: false,
        multiple: false,
        dragDrop: true,
        fileName: "beat[]",
        maxFileCount: 1,
        showError: false,
        acceptFiles: 'audio/mp3',
        showCancel: false,
        showFileCounter: false,
        showFileSize: false,
        uploadStr: config.uploader.labels.mp3_choose,
        onSuccess: function (files, data, xhr, pd) {
            uploaded_files.push(xhr);
            var parsedresponse = JSON.parse(xhr.responseText);
            $('#mp3').val(parsedresponse[0]);
            $(window).trigger('beat_uploaded', [{uploaded_num: uploaded_files.length}]);
        }
    });
    uploaders.uploader_wav = $("#wavdiv").lfUploadFile({
        url: "/admin/beats/audio",
        headers: {
            'field': 'wav',
            'beattitle': config.song_global,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        autoSubmit: false,
        multiple: false,
        fileName: 'beat[]',
        dragDrop: true,
        maxFileCount: 1,
        showError: false,
        acceptFiles: 'audio/wav',
        showCancel: false,
        uploadStr: config.uploader.labels.wav_choose,
        onSuccess: function (files, data, xhr, pd) {
            uploaded_files.push(xhr);
            var parsedresponse = JSON.parse(xhr.responseText);
            $('#wav').val(parsedresponse);
            $(window).trigger('beat_uploaded', [{uploaded_num: uploaded_files.length}]);
        }
    });
    uploaders.uploader_tracked_out = $("#tracked-outdiv").lfUploadFile({
        url: "/admin/beats/audio",
        headers: {
            'field': 'tracked_out',
            'beattitle': config.song_global,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        autoSubmit: false,
        multiple: false,
        fileName: 'beat[]',
        dragDrop: true,
        maxFileCount: 1,
        showError: false,
        acceptFiles: 'audio/*',
        showCancel: false,
        uploadStr: config.uploader.labels.tracked_out_choose,
        onSuccess: function (files, data, xhr, pd) {
            uploaded_files.push(xhr);
            var parsedresponse = JSON.parse(xhr.responseText);
            $('#tracked-out').val(parsedresponse[0]);
            $(window).trigger('beat_uploaded', [{uploaded_num: uploaded_files.length}]);
        }
    });
    window.uploaders = uploaders;

    /*
     *
     * Bindings
     *
     * */

    (function($) {
        $(function() {
            var isoCountries = [
                { id: 'AF', text: 'Afghanistan'},
                { id: 'AX', text: 'Aland Islands'},
                { id: 'AL', text: 'Albania'},
                { id: 'DZ', text: 'Algeria'},
                { id: 'AS', text: 'American Samoa'},
                { id: 'AD', text: 'Andorra'},
                { id: 'AO', text: 'Angola'},
                { id: 'AI', text: 'Anguilla'},
                { id: 'AQ', text: 'Antarctica'},
                { id: 'AG', text: 'Antigua And Barbuda'},
                { id: 'AR', text: 'Argentina'},
                { id: 'AM', text: 'Armenia'},
                { id: 'AW', text: 'Aruba'},
                { id: 'AU', text: 'Australia'},
                { id: 'AT', text: 'Austria'},
                { id: 'AZ', text: 'Azerbaijan'},
                { id: 'BS', text: 'Bahamas'},
                { id: 'BH', text: 'Bahrain'},
                { id: 'BD', text: 'Bangladesh'},
                { id: 'BB', text: 'Barbados'},
                { id: 'BY', text: 'Belarus'},
                { id: 'BE', text: 'Belgium'},
                { id: 'BZ', text: 'Belize'},
                { id: 'BJ', text: 'Benin'},
                { id: 'BM', text: 'Bermuda'},
                { id: 'BT', text: 'Bhutan'},
                { id: 'BO', text: 'Bolivia'},
                { id: 'BA', text: 'Bosnia And Herzegovina'},
                { id: 'BW', text: 'Botswana'},
                { id: 'BV', text: 'Bouvet Island'},
                { id: 'BR', text: 'Brazil'},
                { id: 'IO', text: 'British Indian Ocean Territory'},
                { id: 'BN', text: 'Brunei Darussalam'},
                { id: 'BG', text: 'Bulgaria'},
                { id: 'BF', text: 'Burkina Faso'},
                { id: 'BI', text: 'Burundi'},
                { id: 'KH', text: 'Cambodia'},
                { id: 'CM', text: 'Cameroon'},
                { id: 'CA', text: 'Canada'},
                { id: 'CV', text: 'Cape Verde'},
                { id: 'KY', text: 'Cayman Islands'},
                { id: 'CF', text: 'Central African Republic'},
                { id: 'TD', text: 'Chad'},
                { id: 'CL', text: 'Chile'},
                { id: 'CN', text: 'China'},
                { id: 'CX', text: 'Christmas Island'},
                { id: 'CC', text: 'Cocos (Keeling) Islands'},
                { id: 'CO', text: 'Colombia'},
                { id: 'KM', text: 'Comoros'},
                { id: 'CG', text: 'Congo'},
                { id: 'CD', text: 'Congo}, Democratic Republic'},
                { id: 'CK', text: 'Cook Islands'},
                { id: 'CR', text: 'Costa Rica'},
                { id: 'CI', text: 'Cote D\'Ivoire'},
                { id: 'HR', text: 'Croatia'},
                { id: 'CU', text: 'Cuba'},
                { id: 'CY', text: 'Cyprus'},
                { id: 'CZ', text: 'Czech Republic'},
                { id: 'DK', text: 'Denmark'},
                { id: 'DJ', text: 'Djibouti'},
                { id: 'DM', text: 'Dominica'},
                { id: 'DO', text: 'Dominican Republic'},
                { id: 'EC', text: 'Ecuador'},
                { id: 'EG', text: 'Egypt'},
                { id: 'SV', text: 'El Salvador'},
                { id: 'GQ', text: 'Equatorial Guinea'},
                { id: 'ER', text: 'Eritrea'},
                { id: 'EE', text: 'Estonia'},
                { id: 'ET', text: 'Ethiopia'},
                { id: 'FK', text: 'Falkland Islands (Malvinas)'},
                { id: 'FO', text: 'Faroe Islands'},
                { id: 'FJ', text: 'Fiji'},
                { id: 'FI', text: 'Finland'},
                { id: 'FR', text: 'France'},
                { id: 'GF', text: 'French Guiana'},
                { id: 'PF', text: 'French Polynesia'},
                { id: 'TF', text: 'French Southern Territories'},
                { id: 'GA', text: 'Gabon'},
                { id: 'GM', text: 'Gambia'},
                { id: 'GE', text: 'Georgia'},
                { id: 'DE', text: 'Germany'},
                { id: 'GH', text: 'Ghana'},
                { id: 'GI', text: 'Gibraltar'},
                { id: 'GR', text: 'Greece'},
                { id: 'GL', text: 'Greenland'},
                { id: 'GD', text: 'Grenada'},
                { id: 'GP', text: 'Guadeloupe'},
                { id: 'GU', text: 'Guam'},
                { id: 'GT', text: 'Guatemala'},
                { id: 'GG', text: 'Guernsey'},
                { id: 'GN', text: 'Guinea'},
                { id: 'GW', text: 'Guinea-Bissau'},
                { id: 'GY', text: 'Guyana'},
                { id: 'HT', text: 'Haiti'},
                { id: 'HM', text: 'Heard Island & Mcdonald Islands'},
                { id: 'VA', text: 'Holy See (Vatican City State)'},
                { id: 'HN', text: 'Honduras'},
                { id: 'HK', text: 'Hong Kong'},
                { id: 'HU', text: 'Hungary'},
                { id: 'IS', text: 'Iceland'},
                { id: 'IN', text: 'India'},
                { id: 'ID', text: 'Indonesia'},
                { id: 'IR', text: 'Iran}, Islamic Republic Of'},
                { id: 'IQ', text: 'Iraq'},
                { id: 'IE', text: 'Ireland'},
                { id: 'IM', text: 'Isle Of Man'},
                { id: 'IL', text: 'Israel'},
                { id: 'IT', text: 'Italy'},
                { id: 'JM', text: 'Jamaica'},
                { id: 'JP', text: 'Japan'},
                { id: 'JE', text: 'Jersey'},
                { id: 'JO', text: 'Jordan'},
                { id: 'KZ', text: 'Kazakhstan'},
                { id: 'KE', text: 'Kenya'},
                { id: 'KI', text: 'Kiribati'},
                { id: 'KR', text: 'Korea'},
                { id: 'KW', text: 'Kuwait'},
                { id: 'KG', text: 'Kyrgyzstan'},
                { id: 'LA', text: 'Lao People\'s Democratic Republic'},
                { id: 'LV', text: 'Latvia'},
                { id: 'LB', text: 'Lebanon'},
                { id: 'LS', text: 'Lesotho'},
                { id: 'LR', text: 'Liberia'},
                { id: 'LY', text: 'Libyan Arab Jamahiriya'},
                { id: 'LI', text: 'Liechtenstein'},
                { id: 'LT', text: 'Lithuania'},
                { id: 'LU', text: 'Luxembourg'},
                { id: 'MO', text: 'Macao'},
                { id: 'MK', text: 'Macedonia'},
                { id: 'MG', text: 'Madagascar'},
                { id: 'MW', text: 'Malawi'},
                { id: 'MY', text: 'Malaysia'},
                { id: 'MV', text: 'Maldives'},
                { id: 'ML', text: 'Mali'},
                { id: 'MT', text: 'Malta'},
                { id: 'MH', text: 'Marshall Islands'},
                { id: 'MQ', text: 'Martinique'},
                { id: 'MR', text: 'Mauritania'},
                { id: 'MU', text: 'Mauritius'},
                { id: 'YT', text: 'Mayotte'},
                { id: 'MX', text: 'Mexico'},
                { id: 'FM', text: 'Micronesia}, Federated States Of'},
                { id: 'MD', text: 'Moldova'},
                { id: 'MC', text: 'Monaco'},
                { id: 'MN', text: 'Mongolia'},
                { id: 'ME', text: 'Montenegro'},
                { id: 'MS', text: 'Montserrat'},
                { id: 'MA', text: 'Morocco'},
                { id: 'MZ', text: 'Mozambique'},
                { id: 'MM', text: 'Myanmar'},
                { id: 'NA', text: 'Namibia'},
                { id: 'NR', text: 'Nauru'},
                { id: 'NP', text: 'Nepal'},
                { id: 'NL', text: 'Netherlands'},
                { id: 'AN', text: 'Netherlands Antilles'},
                { id: 'NC', text: 'New Caledonia'},
                { id: 'NZ', text: 'New Zealand'},
                { id: 'NI', text: 'Nicaragua'},
                { id: 'NE', text: 'Niger'},
                { id: 'NG', text: 'Nigeria'},
                { id: 'NU', text: 'Niue'},
                { id: 'NF', text: 'Norfolk Island'},
                { id: 'MP', text: 'Northern Mariana Islands'},
                { id: 'NO', text: 'Norway'},
                { id: 'OM', text: 'Oman'},
                { id: 'PK', text: 'Pakistan'},
                { id: 'PW', text: 'Palau'},
                { id: 'PS', text: 'Palestinian Territory}, Occupied'},
                { id: 'PA', text: 'Panama'},
                { id: 'PG', text: 'Papua New Guinea'},
                { id: 'PY', text: 'Paraguay'},
                { id: 'PE', text: 'Peru'},
                { id: 'PH', text: 'Philippines'},
                { id: 'PN', text: 'Pitcairn'},
                { id: 'PL', text: 'Poland'},
                { id: 'PT', text: 'Portugal'},
                { id: 'PR', text: 'Puerto Rico'},
                { id: 'QA', text: 'Qatar'},
                { id: 'RE', text: 'Reunion'},
                { id: 'RO', text: 'Romania'},
                { id: 'RU', text: 'Russian Federation'},
                { id: 'RW', text: 'Rwanda'},
                { id: 'BL', text: 'Saint Barthelemy'},
                { id: 'SH', text: 'Saint Helena'},
                { id: 'KN', text: 'Saint Kitts And Nevis'},
                { id: 'LC', text: 'Saint Lucia'},
                { id: 'MF', text: 'Saint Martin'},
                { id: 'PM', text: 'Saint Pierre And Miquelon'},
                { id: 'VC', text: 'Saint Vincent And Grenadines'},
                { id: 'WS', text: 'Samoa'},
                { id: 'SM', text: 'San Marino'},
                { id: 'ST', text: 'Sao Tome And Principe'},
                { id: 'SA', text: 'Saudi Arabia'},
                { id: 'SN', text: 'Senegal'},
                { id: 'RS', text: 'Serbia'},
                { id: 'SC', text: 'Seychelles'},
                { id: 'SL', text: 'Sierra Leone'},
                { id: 'SG', text: 'Singapore'},
                { id: 'SK', text: 'Slovakia'},
                { id: 'SI', text: 'Slovenia'},
                { id: 'SB', text: 'Solomon Islands'},
                { id: 'SO', text: 'Somalia'},
                { id: 'ZA', text: 'South Africa'},
                { id: 'GS', text: 'South Georgia And Sandwich Isl.'},
                { id: 'ES', text: 'Spain'},
                { id: 'LK', text: 'Sri Lanka'},
                { id: 'SD', text: 'Sudan'},
                { id: 'SR', text: 'Suriname'},
                { id: 'SJ', text: 'Svalbard And Jan Mayen'},
                { id: 'SZ', text: 'Swaziland'},
                { id: 'SE', text: 'Sweden'},
                { id: 'CH', text: 'Switzerland'},
                { id: 'SY', text: 'Syrian Arab Republic'},
                { id: 'TW', text: 'Taiwan'},
                { id: 'TJ', text: 'Tajikistan'},
                { id: 'TZ', text: 'Tanzania'},
                { id: 'TH', text: 'Thailand'},
                { id: 'TL', text: 'Timor-Leste'},
                { id: 'TG', text: 'Togo'},
                { id: 'TK', text: 'Tokelau'},
                { id: 'TO', text: 'Tonga'},
                { id: 'TT', text: 'Trinidad And Tobago'},
                { id: 'TN', text: 'Tunisia'},
                { id: 'TR', text: 'Turkey'},
                { id: 'TM', text: 'Turkmenistan'},
                { id: 'TC', text: 'Turks And Caicos Islands'},
                { id: 'TV', text: 'Tuvalu'},
                { id: 'UG', text: 'Uganda'},
                { id: 'UA', text: 'Ukraine'},
                { id: 'AE', text: 'United Arab Emirates'},
                { id: 'GB', text: 'United Kingdom'},
                { id: 'US', text: 'United States'},
                { id: 'UM', text: 'United States Outlying Islands'},
                { id: 'UY', text: 'Uruguay'},
                { id: 'UZ', text: 'Uzbekistan'},
                { id: 'VU', text: 'Vanuatu'},
                { id: 'VE', text: 'Venezuela'},
                { id: 'VN', text: 'Viet Nam'},
                { id: 'VG', text: 'Virgin Islands}, British'},
                { id: 'VI', text: 'Virgin Islands}, U.S.'},
                { id: 'WF', text: 'Wallis And Futuna'},
                { id: 'EH', text: 'Western Sahara'},
                { id: 'YE', text: 'Yemen'},
                { id: 'ZM', text: 'Zambia'},
                { id: 'ZW', text: 'Zimbabwe'}
            ];

            function formatCountry (country) {
                if (!country.id) { return country.text; }

                var $country = $(
                    '<span class="flag-icon flag-icon-'+ country.id.toLowerCase() +' flag-icon-squared"></span>' +
                    '<span class="flag-text">'+ country.text+"</span>"
                );
                return $country;
            };

            function template(country, container) {
                var flag = '<span class="flag-icon flag-icon-'+ country.id.toLowerCase() +' flag-icon-squared"></span>';

                return $.parseHTML(flag +' '+ country.text);
            }

            //Assuming you have a select element with name country
            // e.g. <select name="name"></select>

            $("[name='country']").select2({
                placeholder: "Select a country",
                templateResult: formatCountry,
                templateSelection: template,
                data: isoCountries
            });


        });
    })(jQuery)

    $('.page-faq-toggle').on('change', function (e) {
        var optionSelected = $("option:selected", this).val();
        if (optionSelected == 'faq') {
            $('#add_faq').show();
            $('#add_page').hide();
        } else if (optionSelected == 'page') {
            $('#add_faq').hide();
            $('#add_page').show();
        }
    });

    $(document).on('click', '.delete_producer_row', function (e) {
        $(this).parents('div.home-producer-inner-wrapper').remove();
    });
    var i = 0;
    $('.add-new-producer-btn').on('click', function (e) {
        e.preventDefault();
        $("<div class='home-producer-inner-wrapper clearfix'>" +
            "<div class='col-md-5'>" +
                "<input type='hidden' name='id[]'>"+
                "<input type='text' name='title[]' placeholder='Name'>" +
            "<div>" +
            "<div id='"+i+"__producer' class='preview_div_style'>" +
                "<input type='file' name='file_path[]' id='"+i+"__producer_image'>" +
            "</div>" +
            "</div>" +
            "<div class='col-md-4'>" +
            "<div class='row'>" +
            "<input type='number' min='0' name='order[]' id='page-order' placeholder='Ordinal num'>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<div class='col-md-6'>" +
            "<textarea class='faq-textarea' name='description[]' rows='12' placeholder='Description'></textarea>" +
            "</div>" +
            "<div class='col-md-1'>" +
            "<div class='page-single-delete'>" +
            "<a class='delete_producer_row'>" +
            "<button type='button'>X</button>" +
            "</a>" +
            "</div>" +
            "</div>" +
            "</div>").appendTo(".faq-appended");

        $.uploadPreview({
            input_field: i+"__producer_image",
            preview_box: "#"+i+"__producer"
        });
        i++;
    });

     $('.home-producer-inner-wrapper').each(function(){
        var preview = $(this).find('div.preview_div_style').attr('id');
        var preview_input = $(this).find("input[type='file']").attr('id');
         $.uploadPreview({
             input_field: preview_input,
             preview_box: '#'+preview
         });
     });


    $(document).on('change', '.toggle-instance-state', function (e) {
        e.stopPropagation();
        var _this = this;
        var loading = $(_this).closest('td').children('.loader-wrapper');
        $(loading).show();
        $('.alertify-log').remove();
        $.ajax({
                url: "/admin/subinstances/instance/state",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: { active: this.checked ? 1 : 0,
                    id : _this.value
                }
            })
            .done(function (res) {
                $(loading).hide();
                //_this.checked = res.active;
                //_this.checked ? $(_this).closest('tr').removeClass('innactive-affected-row') : $(_this).closest('tr').addClass('innactive-affected-row');
                //alertify[res.type](res.message);
            })
            .fail(function () {
            })
            .always(function () {
            });
    });
    $('#page-save').on('click', function (e) {
        e.preventDefault();
        var error = false;
        var title = $('#page-title');
        var page_desc_val = tinyMCE.get('page-description').getContent();
        var page_desc = $('#page-description').parent('div:first');
        if(title.val() == ''){
            alertify.error( config.messages.please_fill + 'page title' );
            error = true;
            $(title).addClass('has-error-border');
        } else {
            $(title).removeClass('has-error-border');
        }
        if(page_desc_val == ''){
            alertify.error( config.messages.please_fill + 'page description' );
            error = true;
            page_desc.addClass('has-error-border');
        } else {
            page_desc.removeClass('has-error-border');
        }

        if( !error ){
            $("input[name='type']").val( $("option:selected", $('.page-faq-toggle')).val() );
            $('#add_page').submit();
        }


    });
    $('#faq-save').on('click', function (e) {
        $("input[name='type']").val( $("option:selected", $('.page-faq-toggle')).val() );
        e.preventDefault();
        $('#add_faq').submit();
    })

    $('.delete_single_faq').on('click', function(e){
        e.preventDefault();
        $('.alertify-log').remove();
        var _this = this;
        var redirect_url = $(_this).attr('href');
        $('.alertify-log').remove();

        alertify.confirm(config.messages.delete_faq, function (e) {
            if (e) {
                $.ajax( {
                        method: "get",
                        url: redirect_url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    } )
                    .done(function(res) {
                        $(_this).parents('div.faq-update-wrapper:first').remove();
                        alertify[res.type](res.message);
                    })
                    .fail(function() {
                        console.log( "error" );
                    })
                    .always(function() {
                        console.log( "complete" );
                    });
            }
        });
    });

    $('.delete_single_producer').on('click', function(e){
        e.preventDefault();
        var _this = this;
        var redirect_url = $(_this).attr('href');
        $('.alertify-log').remove();

        alertify.confirm(config.messages.delete_producer, function (e) {
            if (e) {
                $.ajax( {
                        method: "get",
                        url: redirect_url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    } )
                    .done(function(res) {
                        $(_this).parents('div.home-producer-inner-wrapper:first').remove();
                        alertify[res.type](res.message);
                    })
                    .fail(function() {
                        console.log( "error" );
                    })
                    .always(function() {
                        console.log( "complete" );
                    });
            }
        });
    });

    $(".add-new-faq-btn").on('click', function (e) {
        e.preventDefault();
        $("<div class='faq-appended-clone clearfix'>"+
            "<div class='faq-question-inner-wrapper clearfix'>"+
            "<div class='col-md-5'>"+
            "<input type='hidden' name='id[]' value=''>"+
            "<input type='text' name='title[]' placeholder='Question'>"+
            "<div class='col-md-4'>"+
            "<div class='row'>"+
            "<input type='number' min='0' name='order[]' id='page-order' placeholder='Ordinal num'>"+
            "</div>"+
            "</div>"+
            "</div>"+
            "<div class='col-md-6'>"+
            "<textarea class='faq-textarea' name='description[]' rows='10' placeholder='Answer'></textarea>"+
            "</div>"+
            "<div class='col-md-1'>"+
            "<div class='page-single-delete'>"+
            "<a class='delete_faq_row'>"+
            "<button id='delete_faq_row' type='button'>X</button>"+
            "</a>"+
            "</div>"+
            "</div>"+
            "</div> </div>").appendTo(".faq-appended");
    });

    $('.category-index-main-wrapper, .page-index-main-wrapper, .beats-index, .subintance-index-main-wrapper').removeClass('table-opacity-zero');

    $(document).on('change', '.beat-active', function () {
        var _this = this;
        var loading = $(_this).closest('td').children('.loader-wrapper');
        $(loading).show();
        $('.alertify-log').remove();

        $.ajax({
                url: "/admin/beats/active/" + _this.value,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: {active: this.checked ? 1 : 0}
            })
            .done(function (res) {
                $(loading).hide();
                _this.checked = res.active;
                _this.checked ? $(_this).closest('tr').removeClass('innactive-affected-row') : $(_this).closest('tr').addClass('innactive-affected-row');
                alertify[res.type](res.message);
            })
            .fail(function () {
            })
            .always(function () {
            });
    });

    $(document).on('change', '.page-active', function () {
        var _this = this;
        var loading = $(_this).closest('td').children('.loader-wrapper');
        $(loading).show();
        $('.alertify-log').remove();

        $.ajax({
                url: "/admin/pages/active/" + _this.value,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: {active: this.checked ? 1 : 0}
            })
            .done(function (res) {
                $(loading).hide();
                _this.checked = res.active;
                _this.checked ? $(_this).closest('tr').removeClass('innactive-affected-row') : $(_this).closest('tr').addClass('innactive-affected-row');
                alertify[res.type](res.message);
            })
            .fail(function () {
            })
            .always(function () {
            });
    });

    $(document).on('click', '.delete_faq_row', function (e) {
        e.preventDefault();
        $(this).parents('div.faq-appended-clone:first').remove();
    })

    $("#category-active").on( 'click', function () {
        $('.category-main-wrapper').toggleClass('innactive-affected-row');
    });
    $("#beat-active").on( 'click', function () {
        $('#opacity-wrapper').toggleClass('innactive-affected-row');
    });
    $("select[name='myTable_length']").on('change', function(){
        session.set('per_page', parseInt(this.value));
    });
    $(window).on('beat_uploaded', function (e, data) {
        if ( ( data.uploaded_num == 3 ) || ( data.uploaded_num == update_uploaders ) ) {
            update_uploaders = 0;
            $("#add_beat").submit();
        }
    });

    $(".a_element").on('click', function (e) {
        e.preventDefault();
        var redirect_url = $(this).attr('href');

        alertify.confirm("Are you sure?", function (e) {
            if (e) {
                window.location.href = redirect_url;
            } else {
            }

        });

    });
    $("#category-save").on('click', function (e) {
        e.preventDefault();
        $('.alertify-log').remove();
        var error = false;

        var cat_title = $('#category-title');
        var cat_desc = $('#category-desc');

        if ( cat_title.val().length == 0 ) {
            cat_title.addClass('has-error-border');
            alertify.error( config.messages.fill_title );
            error = true;
        } else if ( cat_title.val().length > config.max.title_length ) {
            cat_title.addClass('has-error-border');
            alertify.error( config.messages.max_title_chars );
            error = true;
        } else {
            cat_title.removeClass('has-error-border')
        }
        if ( cat_desc.val().length == 0 ) {
            cat_desc.addClass('has-error-border');
            alertify.error( config.messages.fill_category_description );
            error = true;
        } else {
            cat_desc.removeClass('has-error-border')
        }
        var cat_id = $('#cat_id').val();

        if (!error) {
            if (cat_id > 0)
                $('#update_category').submit();
            else
                $('#add_category').submit();
        }

    });
    $('#subinstance-save').on('click', function (e) {
        e.preventDefault();
        $('.alertify-log').remove();
        var error = false;

        var subinstance_name = $('#subinstance-name');
        var subinstance_url = $('#subinstance-url');

        if (subinstance_name.val().length == 0) {
            subinstance_name.addClass('has-error-border');
            alertify.error( config.messages.subinstance_name );
            error = true;
        } else {
            subinstance_name.removeClass('has-error-border')
        }
        if (subinstance_url.val().length == 0) {
            subinstance_url.addClass('has-error-border');
            alertify.error( config.messages.subinstance_url );
            error = true;
        } else if (!isUrlValid(subinstance_url.val())) {
            error = true;
            alertify.error( config.messages.subinstance_properly_url );
            subinstance_url.addClass('has-error-border');
        } else {
            subinstance_url.removeClass('has-error-border')
        }
        var sub_id = $('#sub_id').val();

        if (!error) {
            if (sub_id > 0)
                $('#update_subinstance').submit();
            else
                $('#create_subinstance').submit();
        }

    });

    $(document).on('change', '#faqs-active', function (e) {

        $('#opacity-wrapper').toggleClass('innactive-affected-row');
        $('.alertify-log').remove();

        var _this = this;

        $.ajax( {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/admin/pages/faqs/active",
                data: { active : this.checked ? 1 : 0 }
            } )
            .done(function(res) {
                alertify[res.type](res.message);

                if(res.type == 'error'){
                    $('#opacity-wrapper').toggleClass('innactive-affected-row');

                        $(_this).attr('checked', false);
                        return;

                }
            })
            .fail(function() {
            })
            .always(function() {
            });
    });

    $('#embed_height, #embed_width').on('keyup keydown', handle_embed_create);

    $("#save-embed").on('click', function (e) {
        e.preventDefault();
        $('.alertify-log').remove();
        var error = false;

        var width = $('#embed-width');
        var height = $('#embed-height');
        if( height.val() <= 0 ){
            alertify.error( config.messages.please_fill + $(height).attr('name') );
            error = true;
            height.addClass('has-error-border');
        } else {
            height.removeClass('has-error-border');
        }
        if( width.val() <= 0 ){
            alertify.error( config.messages.please_fill + $(width).attr('name') );
            error = true;
            width.addClass('has-error-border');
        } else {
            width.removeClass('has-error-border');
        }


        if(!error){
            $('#embed-update').submit();
        }
    });
    $("#shop_save_btn").on('click', function (e) {
        e.preventDefault();
        $('.alertify-log').remove();
        var error = false;
        var _this = this;
        //var main_color = $("#main_color");
        //var secondary_color = $("#secondary_color");
        //var third_color = $("#third_color");
        var paypal_email = $("#paypal_email");
        var master_email = $("#master_email");
        var email_content = $("#email_content");
        var thank_you_page = $("#thank_you_page");
        var beat_thumbnail = $('#shop_beat_logo');
        var category_thumbnail = $('#shop_category_logo');

        var country = $("div.shop-country-wrap input[type='hidden']");
console.log(country);
        //if (main_color.val() == '#000000') {
        //    main_color.addClass('has-error-border');
        //    error = true;
        //    alertify.error( config.messages.main_color );
        //} else {
        //    main_color.removeClass('has-error-border');
        //}
        //if (secondary_color.val() == '#000000') {
        //    secondary_color.addClass('has-error-border');
        //    error = true;
        //    alertify.error( config.messages.secondary_color );
        //} else {
        //    secondary_color.removeClass('has-error-border');
        //}
        //if (third_color.val() == '#000000') {
        //    third_color.addClass('has-error-border');
        //    error = true;
        //    alertify.error( config.messages.third_color );
        //} else {
        //    third_color.removeClass('has-error-border');
        //}

//console.log( $(country).find(":selected").text() );
//        if($(country).find(":selected").text() == "Please select country"){
//            $(country).parents('div.flagstrap').addClass('has-error-border');
//            error = true;
//            alertify.error( config.messages.select_image );
//        }
        if(!beat_thumbnail.data('has-image') && $("#image-upload-beat-logo")[0].files.length < 1){
            beat_thumbnail.addClass('has-error-border');
            error = true;
            alertify.error( config.messages.select_image );
        } else {
            beat_thumbnail.removeClass('has-error-border');
        }
        if(!category_thumbnail.data('has-image') && $("#image-upload-category-logo")[0].files.length < 1){
            category_thumbnail.addClass('has-error-border');
            error = true;
            alertify.error( config.messages.select_image );
        } else {
            category_thumbnail.removeClass('has-error-border');
        }
        if (!validateEmail(paypal_email.val())) {
            paypal_email.addClass('has-error-border');
            error = true;
            alertify.error( config.messages.invalid_paypal );
        } else {
            paypal_email.removeClass('has-error-border');
        }
        if (!validateEmail(master_email.val())) {
            master_email.addClass('has-error-border');
            error = true;
            alertify.error( config.messages.invalid_email );
        } else {
            master_email.removeClass('has-error-border');
        }
        if (  tinyMCE.get('email_content').getContent() == '' ) {
            email_content.parent().find('div:first').addClass('has-error-border');
            error = true;
            alertify.error( config.messages.fill_email_content );
        } else {
            email_content.parent().find('div:first').removeClass('has-error-border');
        }
        if ( tinyMCE.get('thank_you_page').getContent() == '' ) {
            thank_you_page.parent().find('div:first').addClass('has-error-border');
            error = true;
            alertify.error( config.messages.fill_thankyou_content );
        } else {
            thank_you_page.parent().find('div:first').removeClass('has-error-border');
        }
        if (!error) {
            $('#shop_option_save').submit();
        }
    });
    /*
     *
     * Ajax Calls
     *
     * */
    $(document).on('change', '.category-active', function () {
        $('.alertify-log').remove();
        var _this = this;
        var loading = $(_this).closest('td').children('.loader-wrapper');
        $(loading).show();

        $.ajax({
                url: config.routes.activate_category + _this.value,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: {active: this.checked ? 1 : 0}
            })
            .done(function (res) {
                $(loading).hide();
                $('.alertify-log').remove();
                _this.checked = res.active;
                if (res.message.indexOf('is last active category in') !== -1) {
                    _this.checked = true;
                } else {
                    _this.checked ? $(_this).closest('tr').removeClass('innactive-affected-row') : $(_this).closest('tr').addClass('innactive-affected-row');
                }
                alertify[res.type](res.message);
            })
            .fail(function () {
            })
            .always(function () {
            });
    });
    $("#banner-save-btn").on('click', function (e) {

        e.preventDefault();
        $('.alertify-log').remove();
        var check_submit = false;
        var error = false;

        $("input[name='banner[]']").each(function () {
            var _this = this;
            var main_parent_div = $(_this).parents('div.col-md-5');
            var label_name = $(main_parent_div).find('div.text-banner').html().toLowerCase();
            label_name = label_name.replace(" banner", "");
            var name = $(main_parent_div).find("input[name='name[]']").val(label_name);

            if( $(_this).get(0).files.length == 1 || !$(_this).parent().css('background-image').includes('/images/banner-preview.jpg') ){
                check_submit = true;
                var url = $(main_parent_div).find("input[name='url[]']");

                if (url.val().length < 1) {
                    error = true;
                    alertify.error('Please fill '+ label_name +' url');
                    url.addClass('has-error-border');
                } else if (!isUrlValid(url.val())) {
                    error = true;
                    alertify.error('Please fill properly main url');
                    url.addClass('has-error-border');
                } else {
                    url.removeClass('has-error-border');
                }
            }
        });

        if (!error && check_submit) {
            $("#save-banner").submit();
        } else if(!check_submit){
            alertify.error("Can't save empty data");
        }

    });
    $('.banner-delete').on('click', function(e){
        e.preventDefault();
        $('.alertify-log').remove();
        var _this = this;
        var parent = $(_this).parent();
        if ($(parent).find("input[type='file']").get(0).files.length == 1 || !$(parent).find("div.banner-image").css('background-image').includes('/images/banner-preview.jpg')) {

            var redirect_url = $(_this).attr('href');

            alertify.confirm("Are you sure that you want to delete this banner", function (e) {
                if (e) {
                    $.ajax({
                            url: redirect_url,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: "get",
                        })
                        .done(function (res) {
                            $(parent).find("input[type='url']").val('');
                            $(parent).find("div.banner-image").removeAttr('style')
                            alertify[res.status](res.message);
                        })
                        .fail(function () {
                        })
                        .always(function () {
                        });
                }

            });
        } else {
            alertify.error("Can't delete empty data");
        }

    });
    $('.default-options').on('click', function (e) {
        e.preventDefault();
        var _this = this;
        var redirect_url = $(_this).attr('href');
        var fields = $(this).data('reset-fields').split(',');

        alertify.confirm("Reset default values?", function (e) {
            if (e) {
                    $.ajax( {
                        method: "post",
                        url: redirect_url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type' : 'application/json'
                        },
                        data:  JSON.stringify(fields)
                    } )
                    .done(function(response) {
                        alertify.success("Successfully " + $(_this).text().toLowerCase() )
                        for( var i = 0; i < Object.keys(response).length; i++ ){
                            var element_name = Object.keys(response)[i];
                            var element = $("#" + Object.keys(response)[i]);
                            $(element).val( response[ Object.keys(response)[i] ] );
                            $(element).trigger('change');
                            if(element_name == ('email_content' || 'thank_you_page' )){
                                tinyMCE.get(element_name).setContent(response[ Object.keys(response)[i] ]);
                            }
                        }
                        $('#shop_save_btn').focus();
                    })
                    .fail(function() {
                        console.log( "error" );
                    })
                    .always(function() {
                        console.log( "complete" );
                    });

            }

        });
    });

    $(".reset-pw-btn").on('click', function(e) {
        e.preventDefault();
        $('.alertify-log').remove();
        var error = false;
        var email = $('#email_reset_pw');

        if (!validateEmail(email.val())) {
            email.addClass('has-error-border');
            error = true;
            alertify.error(config.messages.invalid_email);
        } else {
            email.removeClass('has-error-border');
        }

        if(!error) {

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var res = JSON.parse(xhttp.response);
                    alertify[res.status](res.message);
                }
            };
            xhttp.open("POST", "/password/forgot", true);
            xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhttp.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            xhttp.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded; charset=UTF-8');
            var form_data = 'email=' + email.val();
            xhttp.send( form_data );

        }
    })

    $('.forgot-pw-link').on('click', function (e) {
        e.preventDefault();

        $(".login-form, .forgot-password-form").toggleClass('hidden');
    });
    //$("#faq-update").on('click', function (e) {
    //    e.preventDefault();
    //    $('.alertify-log').remove();
    //    var title = $('#faq-title');
    //    var description = $('#faq-description');
    //    var error = false;
    //    if (title.val().length < 1) {
    //        title.addClass();
    //        error = true;
    //        alertify.error('Please fill faq question');
    //        title.addClass('has-error-border');
    //    } else {
    //        title.removeClass('has-error-border');
    //    }
    //    if (description.val().length < 1) {
    //        description.addClass();
    //        error = true;
    //        alertify.error('Please fill faq question');
    //        description.addClass('has-error-border');
    //    } else {
    //        description.removeClass('has-error-border');
    //    }
    //    if (!error) {
    //        $('#update_faq').submit();
    //    }
    //});
    $("#btn-save-beat").on('click', function (e) {
        e.preventDefault();
        $('.alertify-log').remove();
        var error = false;
        var exclusive_check = document.getElementById("exclusive").checked;
        var num_elements = $("input[type='number']");

        $("input[type='number']").each(function () {
            var minlength = $(this).val();
            var _this = $(this).attr("name");
            if ((_this == 'rate' && minlength == '')) {
                minlength = 601;
            }
            if (minlength == 0) {
                alertify.error( config.messages.please_fill + _this);
                $(this).addClass('has-error-border');
                error = true;
            } else if (_this == 'rate' && minlength > 100 && minlength != 601) {
                alertify.error( config.messages.rate_range );
                $(this).addClass('has-error-border');
                error = true;
            }
            else {
                $(this).removeClass('has-error-border');
            }
        });

        $(".category-box").each(function () {

            var label = $(this).find('label').html().toLowerCase();
            var selected_checkbox_num = $(this).find("input[type='checkbox']:checked").length;
            var _this = this;
            var label_name = $(_this).find('label:eq(0)').text();

            if (selected_checkbox_num == 0) {
                $(this).addClass('has-error-border');
                alertify.error( config.messages.please_fill + label);
                error = true;
            } else if (label_name == 'PRODUCER' && selected_checkbox_num > config.max.producers) {
                $(this).addClass('has-error-border');
                alertify.error( config.messages.producers_max + config.max.producers );
                error = true;
            } else {
                $(this).removeClass('has-error-border');
            }
        });

        var song = $('#song-title').val();
        config.song_global = song;

        var song_label = $('#label-song').text().toLowerCase();
        var beat_cover = $('#image-upload').val();
        var beat_cover_div = $('#beat-cover').css('background-image');

        if (song.length < 3) {
            error = true;
            alertify.error('Please fill ' + song_label);
            $('#song-title').addClass('has-error-border');
        } else if (song.length > 60) {
            error = true;
            alertify.error('Maximum number of characters in song title is 60 characters');
            $('#song-title').addClass('has-error-border');
        }
        else {
            $('#song-title').removeClass('has-error-border');
        }


        if ($('input[name="id"]').val() && !error) {
            uploaders.uploader_mp3.setheaders('beattitle', config.song_global);
            uploaders.uploader_wav.setheaders('beattitle', config.song_global);
            uploaders.uploader_tracked_out.setheaders('beattitle', config.song_global);

            uploaders.uploader_mp3.startUpload();
            uploaders.uploader_wav.startUpload();
            uploaders.uploader_tracked_out.startUpload();

            var file = $("input[name='beat[]']");

            for (var i = 0; i < Object.keys(uploaders).length; i++) {
                update_uploaders += uploaders[Object.keys(uploaders)[i]].getFileCount();
            }

            if (update_uploaders == 0) {
                $("#add_beat").submit();
            }

        } else if (!$('input[name="id"]').val()) {

            uploaders.uploader_mp3.setheaders('beattitle', config.song_global);
            uploaders.uploader_wav.setheaders('beattitle', config.song_global);
            uploaders.uploader_tracked_out.setheaders('beattitle', config.song_global);


            for (var i = 0; i < Object.keys(uploaders).length; i++) {

                if (typeof uploaders[Object.keys(uploaders)[i]] == 'object') {

                    var file_uploaded = uploaders[Object.keys(uploaders)[i]].getFileCount() > 0 ? true : false;
                    if (!file_uploaded) {
                        error = true;
                        $(uploaders[Object.keys(uploaders)[i]]).addClass('has-error-border');
                        var upload_name = uploaders[Object.keys(uploaders)[i]].attr('id')
                        upload_name = upload_name.replace('div', '');
                        upload_name = upload_name.replace('-', ' ');

                        alertify.error('Please upload ' + upload_name + ' file');

                    } else {
                        $(uploaders[Object.keys(uploaders)[i]]).removeClass('has-error-border');
                    }
                }
            }

            if (!error) {
                uploaders.uploader_mp3.startUpload();
                uploaders.uploader_wav.startUpload();
                uploaders.uploader_tracked_out.startUpload();
            }
        }
    });
    $("#sync_all_instances").on('click', function (e) {
        e.preventDefault();
        var _this = $(this).children('div');
        $(_this).addClass('loading-icon')
        $.ajax({
                method: "GET",
                url: config.routes.subinstances_sync,
                data: {}
            })
            .done(function (res) {
                alertify[res.type](res.message);
                $(_this).removeClass('loading-icon')

            })
            .fail(function () {})
            .always(function () {});
    });

    //shop options


    /*
     *
     * Helper functions
     *
     * */
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    function isUrlValid(userInput) {
        var res = userInput.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
        if (res == null)
            return false;
        else
            return true;
    }
    function handle_embed_create(){

        var iframe = $("<iframe />");
        iframe.attr( 'src', lf.getSiteUrl );
        var textarea = $("#embed-code");

        var width_val = $('#embed_width').val();console.log();

        var height_val = $('#embed_height').val();
        iframe.attr( 'width', width_val );
        iframe.attr( 'height', height_val );

        textarea.html( iframe[0].outerHTML );
    }

});