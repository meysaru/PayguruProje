$(document).ready(function () {
    $(".ekleBtn").click(function () {
        var url = "http://localhost/PayguruProje/merchant/"
        var data = {
            p:"sepet",
            urun_id: $(this).attr("urun_id")
        }
        $.post(url,data,function (response) {
            location.reload();
            console.log(response);
        })
    })
})