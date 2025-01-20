<style>
    .tooltip-container {
        position: relative;
        display: inline-block;
        margin: 10px;
        cursor: pointer;
    }

    .tooltip-content {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        max-width: 210px;
        min-height: 100px;
        background: #333;
        color: #fff;
        padding: 10px;
        border-radius: 4px;
        white-space: normal;
        z-index: 999;
        flex-direction: column;
        gap: 20px;
    }
</style>

<div class="tooltip-container">
    <b><a href="tel:+74951468811">+74951468811<span id="bx-cursor-node"> </span></a></b>
    <b>Отдел гарантии</b>
    <div class="tooltip-content">
        <b><a href="tel:+74951468811">+74951468811<span id="bx-cursor-node"> </span></a><br></b>
        <b><a href="tel:+74951468811">+79282427640<span id="bx-cursor-node"> </span></a><br></b>
        <b><a href="mailto:guarantee@white-siberia.ru">guarantee@white-siberia.ru<span id="bx-cursor-node"> </span></a><br></b>
        <div class="buttons_block">
            <span class="btn btn-transparent-border-color animate-load has-ripple"
                  data-event="jqm"
                  data-param-form_id="GUARANTEE"
                  data-name="guarantee">
                Написать сообщение
            </span>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.tooltip-container').on('mouseenter', function () {
            $(this).find('.tooltip-content').css('display', 'flex'); // Показываем окно
        });

        $('.tooltip-container').on('mouseleave', function () {
            const tooltip = $(this).find('.tooltip-content');

            // Проверяем, уходит ли курсор с самого окна
            tooltip.on('mouseleave', function () {
                $(this).css('display', 'none'); // Закрываем окно при уходе курсора
            });
        });
    });
</script>
