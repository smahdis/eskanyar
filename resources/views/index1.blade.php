@extends('layout')

@section('content')

    <div class="container">
        <form id="contactus" action="" method="post">
            <h6>تماس با ما</h6>
            <fieldset> <input placeholder="نام" type="text" tabindex="1" required autofocus> </fieldset>
            <fieldset> <input placeholder="نام خانوادگی" type="text" tabindex="1" required autofocus> </fieldset>
            <fieldset> <input placeholder="شماره تماس" type="text" tabindex="2" required> </fieldset>
            <fieldset> <input placeholder="کد ملی" type="number" tabindex="3" required> </fieldset>
            <fieldset> <input placeholder="تاریخ تولد" type="text" tabindex="2" required> </fieldset>
            <fieldset> <input placeholder="استان" type="text" tabindex="3" required> </fieldset>
            <fieldset> <input placeholder="شهر" type="text" tabindex="3" required> </fieldset>
            <fieldset> <input placeholder="تعداد همراهان مرد (بالای ۵ سال)" type="number" tabindex="3" required> </fieldset>
            <fieldset> <input placeholder="تعداد همراهان زن (بالای ۵ سال)" type="number" tabindex="3" required> </fieldset>
            <fieldset> <input placeholder="تعداد همراهان کودک" type="number" tabindex="3" required> </fieldset>
            <fieldset> <input placeholder="نحوه مسافرات" type="text" tabindex="3" required> </fieldset>
            <fieldset> <textarea placeholder="پیام شما" tabindex="5" required></textarea> </fieldset>
            <fieldset> <button name="submit" type="submit" id="contactus-submit" data-submit="...Sending"><i id="icon" class=""></i> ارسال </button> </fieldset>
        </form>
    </div>

@endsection

@section('footer')
<script>
    $(document).ready(function(){
        $("#contactus-submit").click(function(){
            var r= $('<i class="fa fa-spinner fa-spin"></i>');
            $("#contactus-submit").html(r);
            $("#contactus-submit").append(" در حال ارسال...");
            $("#contactus-submit").attr("disabled", true);


            setTimeout(function(){
                $("#contactus-submit").attr("disabled", false);
                $("#contactus-submit").html('Send');

            }, 3000);


        });
    });
</script>
@endsection
