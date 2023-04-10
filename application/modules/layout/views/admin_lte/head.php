<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard 3</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLTE/dist/css/adminlte.min.css?v=3.2.0">
    
    <?php if (get_setting('monospace_amounts') == 1) { ?>
        <link rel="stylesheet" href="<?php _theme_asset('css/monospace.css'); ?>">
    <?php } ?>
    <style>
        .select2-container{box-sizing:border-box;width:100% !important;display:inline-block;margin:0;position:relative;vertical-align:middle}.select2-container .select2-selection--single{box-sizing:border-box;cursor:pointer;display:block;height:28px;-moz-user-select:none;-ms-user-select:none;user-select:none;-webkit-user-select:none}.select2-container .select2-selection--single .select2-selection__rendered{display:block;padding-left:8px;padding-right:20px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.select2-container .select2-selection--single .select2-selection__clear{position:relative}.select2-container[dir="rtl"] .select2-selection--single .select2-selection__rendered{padding-right:8px;padding-left:20px}.select2-container .select2-selection--multiple{box-sizing:border-box;cursor:pointer;display:block;min-height:32px;-moz-user-select:none;-ms-user-select:none;user-select:none;-webkit-user-select:none}.select2-container .select2-selection--multiple .select2-selection__rendered{display:inline-block;overflow:hidden;padding-left:8px;text-overflow:ellipsis;white-space:nowrap}.select2-container .select2-search--inline{float:left}.select2-container .select2-search--inline .select2-search__field{box-sizing:border-box;border:none;font-size:100%;margin-top:5px;padding:0}.select2-container .select2-search--inline .select2-search__field::-webkit-search-cancel-button{-webkit-appearance:none}.select2-dropdown{background-color:white;border:1px solid #aaa;border-radius:4px;box-sizing:border-box;display:block;position:absolute;left:-100000px;width:100%;z-index:1051}.select2-results{display:block}.select2-results__options{list-style:none;margin:0;padding:0}.select2-results__option{padding:6px;-moz-user-select:none;-ms-user-select:none;user-select:none;-webkit-user-select:none}.select2-results__option[aria-selected]{cursor:pointer}.select2-container--open .select2-dropdown{left:0}.select2-container--open .select2-dropdown--above{border-bottom:none;border-bottom-left-radius:0;border-bottom-right-radius:0}.select2-container--open .select2-dropdown--below{border-top:none;border-top-left-radius:0;border-top-right-radius:0}.select2-search--dropdown{display:block;padding:4px}.select2-search--dropdown .select2-search__field{padding:4px;width:100%;box-sizing:border-box}.select2-search--dropdown .select2-search__field::-webkit-search-cancel-button{-webkit-appearance:none}.select2-search--dropdown.select2-search--hide{display:none}.select2-close-mask{border:0;margin:0;padding:0;display:block;position:fixed;left:0;top:0;min-height:100%;min-width:100%;height:auto;width:auto;opacity:0;z-index:99;background-color:#fff;filter:alpha(opacity=0)}.select2-hidden-accessible{border:0 !important;clip:rect(0 0 0 0) !important;height:1px !important;margin:-1px !important;overflow:hidden !important;padding:0 !important;position:absolute !important;width:1px !important}.select2-container--default{display:block}.select2-container--default .select2-selection{background-color:#fff;border:1px solid #ccc;border-radius:4px;color:#555;font-size:14px;outline:0}.select2-container--default .select2-selection.form-control{border-radius:4px}.select2-container--default .select2-search--dropdown .select2-search__field{background-color:#fff;border:1px solid #ccc;border-radius:4px;color:#555;font-size:14px}.select2-container--default .select2-search__field{outline:0}.select2-container--default .select2-search__field::-webkit-input-placeholder{color:#999}.select2-container--default .select2-search__field:-moz-placeholder{color:#999}.select2-container--default .select2-search__field::-moz-placeholder{color:#999;opacity:1}.select2-container--default .select2-search__field:-ms-input-placeholder{color:#999}.select2-container--default .select2-results__option{padding:6px 12px}.select2-container--default .select2-results__option[role=group]{padding:0}.select2-container--default .select2-results__option[aria-disabled=true]{color:#777;cursor:not-allowed}.select2-container--default .select2-results__option[aria-selected=true]{background-color:#f5f5f5;color:#262626}.select2-container--default .select2-results__option--highlighted[aria-selected]{background-color:#2C8EDD;color:#fff}.select2-container--default .select2-results__option .select2-results__option{padding:6px 12px}.select2-container--default .select2-results__option .select2-results__option .select2-results__group{padding-left:0}.select2-container--default .select2-results__option .select2-results__option .select2-results__option{margin-left:-12px;padding-left:24px}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-24px;padding-left:36px}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-36px;padding-left:48px}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-48px;padding-left:60px}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-60px;padding-left:72px}.select2-container--default .select2-results__group{color:#777;display:block;padding:6px 12px;font-size:12px;line-height:1.428571429;white-space:nowrap}.select2-container--default.select2-container--focus .select2-selection,.select2-container--default.select2-container--open .select2-selection{transition:border-color ease-in-out 0.15s,box-shadow ease-in-out 0.15s;border-color:#66afe9}.select2-container--default.select2-container--open .select2-selection .select2-selection__arrow b{border-color:transparent transparent #999 transparent;border-width:0 4px 4px 4px}.select2-container--default.select2-container--open.select2-container--below .select2-selection{border-bottom-right-radius:0;border-bottom-left-radius:0;border-bottom-color:transparent}.select2-container--default.select2-container--open.select2-container--above .select2-selection{border-top-left-radius:0;border-top-right-radius:0;border-top-color:transparent}.select2-container--default .select2-selection__clear{color:#999;cursor:pointer;float:right;font-weight:bold;margin-right:10px}.select2-container--default .select2-selection__clear:hover{color:#333}.select2-container--default.select2-container--disabled .select2-selection{border-color:#ccc;box-shadow:none}.select2-container--default.select2-container--disabled .select2-selection,.select2-container--default.select2-container--disabled .select2-search__field{cursor:not-allowed}.select2-container--default.select2-container--disabled .select2-selection,.select2-container--default.select2-container--disabled .select2-selection--multiple .select2-selection__choice{background-color:#eee}.select2-container--default.select2-container--disabled .select2-selection__clear,.select2-container--default.select2-container--disabled .select2-selection--multiple .select2-selection__choice__remove{display:none}.select2-container--default .select2-dropdown{border-color:#66afe9;overflow-x:hidden;margin-top:-1px}.select2-container--default .select2-dropdown--above{margin-top:1px}.select2-container--default .select2-results>.select2-results__options{max-height:200px;overflow-y:auto}.select2-container--default .select2-selection--single{height:34px;line-height:1.428571429;padding:6px 24px 6px 12px}.select2-container--default .select2-selection--single .select2-selection__arrow{position:absolute;bottom:0;right:12px;top:0;width:4px}.select2-container--default .select2-selection--single .select2-selection__arrow b{border-color:#999 transparent transparent transparent;border-style:solid;border-width:4px 4px 0 4px;height:0;left:0;margin-left:-4px;margin-top:-2px;position:absolute;top:50%;width:0}.select2-container--default .select2-selection--single .select2-selection__rendered{color:#555;padding:0}.select2-container--default .select2-selection--single .select2-selection__placeholder{color:#999}.select2-container--default .select2-selection--multiple{min-height:34px;padding:0;height:auto}.select2-container--default .select2-selection--multiple .select2-selection__rendered{box-sizing:border-box;display:block;line-height:1.428571429;list-style:none;margin:0;overflow:hidden;padding:0;width:100%;text-overflow:ellipsis;white-space:nowrap}.select2-container--default .select2-selection--multiple .select2-selection__placeholder{color:#999;float:left;margin-top:5px}.select2-container--default .select2-selection--multiple .select2-selection__choice{color:#555;background:#fff;border:1px solid #ccc;border-radius:4px;cursor:default;float:left;margin:5px 0 0 6px;padding:0 6px}.select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field{background:transparent;padding:0 12px;height:32px;line-height:1.428571429;margin-top:0;min-width:5em}.select2-container--default .select2-selection--multiple .select2-selection__choice__remove{color:#999;cursor:pointer;display:inline-block;font-weight:bold;margin-right:3px}.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover{color:#333}.select2-container--default .select2-selection--multiple .select2-selection__clear{margin-top:6px}.select2-container--default .select2-selection--single.input-sm,.select2-container--default .input-group-sm>.select2-selection--single.form-control,.select2-container--default .input-group-sm>.select2-selection--single.input-group-addon,.select2-container--default .input-group-sm>.input-group-btn>.select2-selection--single.btn,.input-group-sm .select2-container--default .select2-selection--single,.form-group-sm .select2-container--default .select2-selection--single{border-radius:3px;font-size:12px;height:30px;line-height:1.5;padding:5px 22px 5px 10px}.select2-container--default .select2-selection--single.input-sm .select2-selection__arrow b,.select2-container--default .input-group-sm>.select2-selection--single.form-control .select2-selection__arrow b,.select2-container--default .input-group-sm>.select2-selection--single.input-group-addon .select2-selection__arrow b,.select2-container--default .input-group-sm>.input-group-btn>.select2-selection--single.btn .select2-selection__arrow b,.input-group-sm .select2-container--default .select2-selection--single .select2-selection__arrow b,.form-group-sm .select2-container--default .select2-selection--single .select2-selection__arrow b{margin-left:-5px}.select2-container--default .select2-selection--multiple.input-sm,.select2-container--default .input-group-sm>.select2-selection--multiple.form-control,.select2-container--default .input-group-sm>.select2-selection--multiple.input-group-addon,.select2-container--default .input-group-sm>.input-group-btn>.select2-selection--multiple.btn,.input-group-sm .select2-container--default .select2-selection--multiple,.form-group-sm .select2-container--default .select2-selection--multiple{min-height:30px;border-radius:3px}.select2-container--default .select2-selection--multiple.input-sm .select2-selection__choice,.select2-container--default .input-group-sm>.select2-selection--multiple.form-control .select2-selection__choice,.select2-container--default .input-group-sm>.select2-selection--multiple.input-group-addon .select2-selection__choice,.select2-container--default .input-group-sm>.input-group-btn>.select2-selection--multiple.btn .select2-selection__choice,.input-group-sm .select2-container--default .select2-selection--multiple .select2-selection__choice,.form-group-sm .select2-container--default .select2-selection--multiple .select2-selection__choice{font-size:12px;line-height:1.5;margin:4px 0 0 5px;padding:0 5px}.select2-container--default .select2-selection--multiple.input-sm .select2-search--inline .select2-search__field,.select2-container--default .input-group-sm>.select2-selection--multiple.form-control .select2-search--inline .select2-search__field,.select2-container--default .input-group-sm>.select2-selection--multiple.input-group-addon .select2-search--inline .select2-search__field,.select2-container--default .input-group-sm>.input-group-btn>.select2-selection--multiple.btn .select2-search--inline .select2-search__field,.input-group-sm .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field,.form-group-sm .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field{padding:0 10px;font-size:12px;height:28px;line-height:1.5}.select2-container--default .select2-selection--multiple.input-sm .select2-selection__clear,.select2-container--default .input-group-sm>.select2-selection--multiple.form-control .select2-selection__clear,.select2-container--default .input-group-sm>.select2-selection--multiple.input-group-addon .select2-selection__clear,.select2-container--default .input-group-sm>.input-group-btn>.select2-selection--multiple.btn .select2-selection__clear,.input-group-sm .select2-container--default .select2-selection--multiple .select2-selection__clear,.form-group-sm .select2-container--default .select2-selection--multiple .select2-selection__clear{margin-top:5px}.select2-container--default .select2-selection--single.input-lg,.select2-container--default .input-group-lg>.select2-selection--single.form-control,.select2-container--default .input-group-lg>.select2-selection--single.input-group-addon,.select2-container--default .input-group-lg>.input-group-btn>.select2-selection--single.btn,.input-group-lg .select2-container--default .select2-selection--single,.form-group-lg .select2-container--default .select2-selection--single{border-radius:6px;font-size:18px;height:46px;line-height:1.3333333;padding:10px 31px 10px 16px}.select2-container--default .select2-selection--single.input-lg .select2-selection__arrow,.select2-container--default .input-group-lg>.select2-selection--single.form-control .select2-selection__arrow,.select2-container--default .input-group-lg>.select2-selection--single.input-group-addon .select2-selection__arrow,.select2-container--default .input-group-lg>.input-group-btn>.select2-selection--single.btn .select2-selection__arrow,.input-group-lg .select2-container--default .select2-selection--single .select2-selection__arrow,.form-group-lg .select2-container--default .select2-selection--single .select2-selection__arrow{width:5px}.select2-container--default .select2-selection--single.input-lg .select2-selection__arrow b,.select2-container--default .input-group-lg>.select2-selection--single.form-control .select2-selection__arrow b,.select2-container--default .input-group-lg>.select2-selection--single.input-group-addon .select2-selection__arrow b,.select2-container--default .input-group-lg>.input-group-btn>.select2-selection--single.btn .select2-selection__arrow b,.input-group-lg .select2-container--default .select2-selection--single .select2-selection__arrow b,.form-group-lg .select2-container--default .select2-selection--single .select2-selection__arrow b{border-width:5px 5px 0 5px;margin-left:-5px;margin-left:-10px;margin-top:-2.5px}.select2-container--default .select2-selection--multiple.input-lg,.select2-container--default .input-group-lg>.select2-selection--multiple.form-control,.select2-container--default .input-group-lg>.select2-selection--multiple.input-group-addon,.select2-container--default .input-group-lg>.input-group-btn>.select2-selection--multiple.btn,.input-group-lg .select2-container--default .select2-selection--multiple,.form-group-lg .select2-container--default .select2-selection--multiple{min-height:46px;border-radius:6px}.select2-container--default .select2-selection--multiple.input-lg .select2-selection__choice,.select2-container--default .input-group-lg>.select2-selection--multiple.form-control .select2-selection__choice,.select2-container--default .input-group-lg>.select2-selection--multiple.input-group-addon .select2-selection__choice,.select2-container--default .input-group-lg>.input-group-btn>.select2-selection--multiple.btn .select2-selection__choice,.input-group-lg .select2-container--default .select2-selection--multiple .select2-selection__choice,.form-group-lg .select2-container--default .select2-selection--multiple .select2-selection__choice{font-size:18px;line-height:1.3333333;border-radius:4px;margin:9px 0 0 8px;padding:0 10px}.select2-container--default .select2-selection--multiple.input-lg .select2-search--inline .select2-search__field,.select2-container--default .input-group-lg>.select2-selection--multiple.form-control .select2-search--inline .select2-search__field,.select2-container--default .input-group-lg>.select2-selection--multiple.input-group-addon .select2-search--inline .select2-search__field,.select2-container--default .input-group-lg>.input-group-btn>.select2-selection--multiple.btn .select2-search--inline .select2-search__field,.input-group-lg .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field,.form-group-lg .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field{padding:0 16px;font-size:18px;height:44px;line-height:1.3333333}.select2-container--default .select2-selection--multiple.input-lg .select2-selection__clear,.select2-container--default .input-group-lg>.select2-selection--multiple.form-control .select2-selection__clear,.select2-container--default .input-group-lg>.select2-selection--multiple.input-group-addon .select2-selection__clear,.select2-container--default .input-group-lg>.input-group-btn>.select2-selection--multiple.btn .select2-selection__clear,.input-group-lg .select2-container--default .select2-selection--multiple .select2-selection__clear,.form-group-lg .select2-container--default .select2-selection--multiple .select2-selection__clear{margin-top:10px}.select2-container--default .select2-selection.input-lg.select2-container--open .select2-selection--single .select2-selection__arrow b,.select2-container--default .input-group-lg>.select2-selection.select2-container--open.form-control .select2-selection--single .select2-selection__arrow b,.select2-container--default .input-group-lg>.select2-selection.select2-container--open.input-group-addon .select2-selection--single .select2-selection__arrow b,.select2-container--default .input-group-lg>.input-group-btn>.select2-selection.select2-container--open.btn .select2-selection--single .select2-selection__arrow b{border-color:transparent transparent #999 transparent;border-width:0 5px 5px 5px}.input-group-lg .select2-container--default .select2-selection.select2-container--open .select2-selection--single .select2-selection__arrow b{border-color:transparent transparent #999 transparent;border-width:0 5px 5px 5px}.select2-container--default[dir="rtl"] .select2-selection--single{padding-left:24px;padding-right:12px}.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__rendered{padding-right:0;padding-left:0;text-align:right}.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__clear{float:left}.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__arrow{left:12px;right:auto}.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__arrow b{margin-left:0}.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice,.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__placeholder{float:right}.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice{margin-left:0;margin-right:6px}.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove{margin-left:2px;margin-right:auto}.has-warning .select2-dropdown,.has-warning .select2-selection{border-color:#8a6d3b}.has-warning .select2-container--focus .select2-selection,.has-warning .select2-container--open .select2-selection{border-color:#66512c}.has-warning.select2-drop-active{border-color:#66512c}.has-warning.select2-drop-active.select2-drop.select2-drop-above{border-top-color:#66512c}.has-error .select2-dropdown,.has-error .select2-selection{border-color:#a94442}.has-error .select2-container--focus .select2-selection,.has-error .select2-container--open .select2-selection{border-color:#843534}.has-error.select2-drop-active{border-color:#843534}.has-error.select2-drop-active.select2-drop.select2-drop-above{border-top-color:#843534}.has-success .select2-dropdown,.has-success .select2-selection{border-color:#3c763d}.has-success .select2-container--focus .select2-selection,.has-success .select2-container--open .select2-selection{border-color:#2b542c}.has-success.select2-drop-active{border-color:#2b542c}.has-success.select2-drop-active.select2-drop.select2-drop-above{border-top-color:#2b542c}.input-group .select2-container--default{display:table;table-layout:fixed;position:relative;z-index:2;float:left;width:100%;margin-bottom:0}.input-group .select2-container--default.select2-container--open,.input-group .select2-container--default.select2-container--focus{z-index:3}.input-group.select2-bootstrap-prepend .select2-container--default .select2-selection{border-top-left-radius:0;border-bottom-left-radius:0}.input-group.select2-bootstrap-append .select2-container--default .select2-selection{border-top-right-radius:0;border-bottom-right-radius:0}.select2-bootstrap-append .select2-container--default,.select2-bootstrap-append .input-group-btn,.select2-bootstrap-append .input-group-btn .btn,.select2-bootstrap-prepend .select2-container--default,.select2-bootstrap-prepend .input-group-btn,.select2-bootstrap-prepend .input-group-btn .btn{vertical-align:top}.form-control.select2-hidden-accessible{position:absolute !important;width:1px !important}.form-inline .select2-container--default{display:inline-block}.input-sm+.select2 .select2-selection,.input-group-sm>.form-control+.select2 .select2-selection,.input-group-sm>.input-group-addon+.select2 .select2-selection,.input-group-sm>.input-group-btn>.btn+.select2 .select2-selection{height:30px;padding:5px 10px;font-size:12px;line-height:1.5;border-radius:3px}
    </style>

    <script src="<?php _core_asset('js/dependencies.min.js'); ?>"></script>
    <script nonce="a4c24203-dc8a-4137-a265-a9b5c198c38d">
        (function(w, d) {
            ! function(bv, bw, bx, by) {
                bv[bx] = bv[bx] || {};
                bv[bx].executed = [];
                bv.zaraz = {
                    deferred: [],
                    listeners: []
                };
                bv.zaraz.q = [];
                bv.zaraz._f = function(bz) {
                    return function() {
                        var bA = Array.prototype.slice.call(arguments);
                        bv.zaraz.q.push({
                            m: bz,
                            a: bA
                        })
                    }
                };
                for (const bB of ["track", "set", "debug"]) bv.zaraz[bB] = bv.zaraz._f(bB);
                bv.zaraz.init = () => {
                    var bC = bw.getElementsByTagName(by)[0],
                        bD = bw.createElement(by),
                        bE = bw.getElementsByTagName("title")[0];
                    bE && (bv[bx].t = bw.getElementsByTagName("title")[0].text);
                    bv[bx].x = Math.random();
                    bv[bx].w = bv.screen.width;
                    bv[bx].h = bv.screen.height;
                    bv[bx].j = bv.innerHeight;
                    bv[bx].e = bv.innerWidth;
                    bv[bx].l = bv.location.href;
                    bv[bx].r = bw.referrer;
                    bv[bx].k = bv.screen.colorDepth;
                    bv[bx].n = bw.characterSet;
                    bv[bx].o = (new Date).getTimezoneOffset();
                    if (bv.dataLayer)
                        for (const bI of Object.entries(Object.entries(dataLayer).reduce(((bJ, bK) => ({
                                ...bJ[1],
                                ...bK[1]
                            }))))) zaraz.set(bI[0], bI[1], {
                            scope: "page"
                        });
                    bv[bx].q = [];
                    for (; bv.zaraz.q.length;) {
                        const bL = bv.zaraz.q.shift();
                        bv[bx].q.push(bL)
                    }
                    bD.defer = !0;
                    for (const bM of [localStorage, sessionStorage]) Object.keys(bM || {}).filter((bO => bO.startsWith("_zaraz_"))).forEach((bN => {
                        try {
                            bv[bx]["z_" + bN.slice(7)] = JSON.parse(bM.getItem(bN))
                        } catch {
                            bv[bx]["z_" + bN.slice(7)] = bM.getItem(bN)
                        }
                    }));
                    bD.referrerPolicy = "origin";
                    bD.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(bv[bx])));
                    bC.parentNode.insertBefore(bD, bC)
                };
                ["complete", "interactive"].includes(bw.readyState) ? zaraz.init() : bv.addEventListener("DOMContentLoaded", zaraz.init)
            }(w, d, "zarazData", "script");
        })(window, document);
    </script>

    <script>
    Dropzone.autoDiscover = false;

    <?php if (trans('cldr') != 'en') { ?>
    $.fn.select2.defaults.set('language', '<?php _trans('cldr'); ?>');
    <?php } ?>

    $(function () {
        $('.nav-tabs').tab();
        $('.tip').tooltip();

        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#bank-table tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        

        $('body').on('focus', '.datepicker', function () {
            $(this).datepicker({
                autoclose: true,
                disableTouchKeyboard: true,
                Readonly: true,
                format: '<?php echo date_format_datepicker(); ?>',
                language: '<?php _trans('cldr'); ?>',
                weekStart: '<?php echo get_setting('first_day_of_week'); ?>',
                todayBtn: "linked"
            });
        });

        $('body').on('focus', '.datepickerItem', function () {
            $(this).datepicker({
                autoclose: true,
                disableTouchKeyboard: true,
                Readonly: true,
                format: '<?php echo date_format_datepicker(); ?>',
                language: '<?php _trans('cldr'); ?>',
                weekStart: '<?php echo get_setting('first_day_of_week'); ?>',
                todayBtn: "linked"
            });

            $(this).datepicker().on('changeDate', function(e) {
                tstart=$(this).closest('table tbody.item').find('[name="item_date_start"]').val();
                tend=$(this).closest('table tbody.item').find('[name="item_date_end"]').val();
                
                var dateAr = tstart.split('-');
                var start = new Date("'"+dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0]+"'");
                
                dateAr=tend.split('-');
                
                var end = new Date(dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0]);
                var diffDays = parseInt((end - start) / (1000 * 60 * 60 * 24), 10); 
                
                $(this).closest('table tbody.item').find('[name="item_quantity"]').val(diffDays);
            });
        });

        $(document).on('click', '.create-invoice', function () {
            $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_create_invoice'); ?>");
        });

        $(document).on('click', '.create-reservation', function () {
            $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_create_reservation'); ?>");
        });

        $(document).on('click', '.create-quote', function () {
            $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_create_quote'); ?>");
        });

        $(document).on('click', '#btn_quote_to_invoice', function () {
            var quote_id = $(this).data('quote-id');
            $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_quote_to_invoice'); ?>/" + quote_id);
        });

        $(document).on('click', '#btn_copy_invoice', function () {
            var invoice_id = $(this).data('invoice-id');
            $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_copy_invoice'); ?>", {invoice_id: invoice_id});
        });

        $(document).on('click', '#btn_create_credit', function () {
            var invoice_id = $(this).data('invoice-id');
            $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_create_credit'); ?>", {invoice_id: invoice_id});
        });

        $(document).on('click', '#btn_copy_quote', function () {
            var quote_id = $(this).data('quote-id');
            var client_id = $(this).data('client-id');
            $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_copy_quote'); ?>", {
                quote_id: quote_id,
                client_id: client_id
            });
        });

        $(document).on('click', '.client-create-invoice', function () {
            var client_id = $(this).data('client-id');
            $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_create_invoice'); ?>", {client_id: client_id});
        });

        $(document).on('click', '.client-create-quote', function () {
            var client_id = $(this).data('client-id');
            $('#modal-placeholder').load("<?php echo site_url('quotes/ajax/modal_create_quote'); ?>", {client_id: client_id});
        });

        $(document).on('click', '.invoice-add-payment', function () {
            var invoice_id = $(this).data('invoice-id');
            var invoice_balance = $(this).data('invoice-balance');
            var invoice_payment_method = $(this).data('invoice-payment-method');
            var payment_cf_exist =  $(this).data('payment-cf-exist');
            $('#modal-placeholder').load("<?php echo site_url('payments/ajax/modal_add_payment'); ?>", {
                invoice_id: invoice_id,
                invoice_balance: invoice_balance,
                invoice_payment_method: invoice_payment_method,
                payment_cf_exist: payment_cf_exist
            });
        });

    });
</script>
<script src="<?php _core_asset('js/dependencies.min.js'); ?>"></script>
<?php if (trans('cldr') != 'en') { ?>
    <script src="<?php _core_asset('js/locales/select2/' . trans('cldr') . '.js'); ?>"></script>
<?php } ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

<script src="<?php echo base_url(); ?>/custom_assets/styles/js/daypilot-all.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

</head>