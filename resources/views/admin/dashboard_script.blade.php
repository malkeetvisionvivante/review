<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $('#datepicker1').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });
    $('#datepicker2').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });
    jQuery.validator.addMethod("greaterThan", 
    function(value, element, params) {
        if (new Date($('#datepicker1').val()) > new Date($('#datepicker2').val())){ return false; }
        return true;
    },'Must be greater than From Date.');
    jQuery('#visitor-form').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            start_date:{
                required:true,
            },
            end_date:{
                required:true,
                greaterThan: true
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "start_date") {
                error.appendTo("#errorVisitorStartDate");
            } else if (element.attr("name") == "end_date") {
                error.appendTo("#errorVisitorEndDate");
            } else {
                error.insertAfter(element);
            }
        }
      });
</script>
<script type="text/javascript">
    $('#datepicker3').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });
    $('#datepicker4').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });
    jQuery.validator.addMethod("greaterThan1", 
    function(value, element, params) {
        if (new Date($('#datepicker3').val()) > new Date($('#datepicker4').val())){ return false; }
        return true;
    },'Must be greater than From Date.');
    jQuery('#review-form').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            start_date:{
                required:true,
            },
            end_date:{
                required:true,
                greaterThan1: true
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "start_date") {
                error.appendTo("#errorReviewStartDate");
            } else if (element.attr("name") == "end_date") {
                error.appendTo("#errorReviewEndDate");
            } else {
                error.insertAfter(element);
            }
        }
      });
</script>
<script type="text/javascript">
    $('#datepicker5').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });
    $('#datepicker6').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });
    jQuery.validator.addMethod("greaterThan2", 
    function(value, element, params) {
        if (new Date($('#datepicker5').val()) > new Date($('#datepicker6').val())){ return false; }
        return true;
    },'Must be greater than From Date.');
    jQuery('#signup-user-form').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            start_date:{
                required:true,
            },
            from:{
                required:true,
                number:true,
                min:0,
            },
            to:{
                required:true,
                number:true,
                //max:10000,
            },
            end_date:{
                required:true,
                greaterThan2: true
            },
            "account_type[]":{
                required:true,
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "start_date") {
                error.appendTo("#errorSignupUserStartDate");
            } else if (element.attr("name") == "end_date") {
                error.appendTo("#errorSignupUserEndDate");
            } else if (element.attr("name") == "account_type[]") {
                error.appendTo("#errorSignupUserAccountType");
            } else {
                error.insertAfter(element);
            }
        }
      });
</script>
<script type="text/javascript">
    $('#datepicker7').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });
    $('#datepicker8').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });
    jQuery.validator.addMethod("greaterThan3", 
    function(value, element, params) {
        if (new Date($('#datepicker7').val()) > new Date($('#datepicker8').val())){ return false; }
        return true;
    },'Must be greater than From Date.');
    jQuery('#referrals-form').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            start_date:{
                required:true,
            },
            end_date:{
                required:true,
                greaterThan3: true
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "start_date") {
                error.appendTo("#errorReferralsStartDate");
            } else if (element.attr("name") == "end_date") {
                error.appendTo("#errorReferralsEndDate");
            } else {
                error.insertAfter(element);
            }
        }
      });
</script>
<script type="text/javascript">
    $('#datepicker9').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });
    $('#datepicker10').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });
    jQuery.validator.addMethod("greaterThan4", 
    function(value, element, params) {
        if (new Date($('#datepicker9').val()) > new Date($('#datepicker10').val())){ return false; }
        return true;
    },'Must be greater than From Date.');
    jQuery('#review-per-use-form').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            start_date:{
                required:true,
            },
            end_date:{
                required:true,
                greaterThan4: true
            },
            from:{
                required:true,
                number:true,
                min:0,
            },
            to:{
                required:true,
                number:true,
                //max:10000,
            },
            "account_type[]":{
                required:true,
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "start_date") {
                error.appendTo("#errorReviewPerUserStartDate");
            } else if (element.attr("name") == "end_date") {
                error.appendTo("#errorReviewPerUserEndDate");
            } else if (element.attr("name") == "account_type[]") {
                error.appendTo("#errorReviewPerUserAccountType");
            } else {
                error.insertAfter(element);
            }
        }
      });
</script>