<a id="move-top" class="animate-move-top bg-primary">
    <li class="fa fa-angle-up text-white"></li>
</a>

<style>
.animate-move-top {
    cursor: pointer;
    text-align: center;
    border-radius: 50%;
    position: fixed;
    bottom: -55px;
    right: 15px;
    padding: 0 13px;
    font-size: 30px;
    z-index: 99;
    opacity: 0;
    transition: .35s ease-in-out;
}

.animate-move-top:hover {
    color: deepskyblue;
    box-shadow: 0 3px 10px black;
}

.showbottom {
    bottom: 15px;
}

.rotateleft {
    transform: rotate(-450deg);
}

.rotateleft:hover {
    transform: scale(1.1) rotate(-450deg);
}

.rotateup {
    transform: rotate(0deg);
}

.rotateup:hover {
    transform: scale(1.1) rotate(0deg);
}

.op1 {
    opacity: 1;
}

</style>

<script>
    if(<?=isset($noback) ? 'true' : 'false' ?>) {
        window.onscroll = function() {scrollFunction()};
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            $("#move-top").addClass("op1");
        } else {
            $("#move-top").removeClass("op1");
        }

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                $("#move-top").addClass("op1");
                $("#move-top").addClass("showbottom");
            } else {
                $("#move-top").removeClass("op1");
                $("#move-top").removeClass("showbottom");
            }
        }

        $("#move-top").click(function() {
            $("html, body").animate({ scrollTop: 0 }, "fast");
            return false;
        });
    } else {
        setTimeout(() => {
            window.onscroll = function() {scrollFunction()};

            $("#move-top").addClass("showbottom");
            $("#move-top").addClass("op1");

            scrollFunction()

            function scrollFunction() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    $("#move-top").removeClass("rotateleft");
                    $("#move-top").addClass("rotateup");
                } else {
                    $("#move-top").addClass("rotateleft");
                    $("#move-top").removeClass("rotateup");
                }
            }

            $("#move-top").click(function() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    $("html, body").animate({ scrollTop: 0 }, "fast");
                } else {
                    history.back();
                }
            });
        }, 0)
    }
</script>