<div class="modal fade" id="tourOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Заказать тур</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group" id="name">
                        <label for="name">Ваше имя</label>
                        <span></span>
                        <input type="name" name="name" class="form-control" placeholder="Иван Иванов">
                    </div>
                    <div class="form-group" id="email">
                        <label for="email">Email</label>
                        <span></span>
                        <input type="email" name="email" class="form-control" placeholder="ivanov@mail.ru">
                    </div>
                    <div class="form-group" id="phone">
                        <label for="phone">Телефон</label>
                        <span></span>
                        <input type="text" name="phone" class="form-control" placeholder="8 920 888 88 88">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="comment" id="comment"></textarea>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-default" data-dismiss="modal">Закрыть</a>
                <a type="button" class="btn btn-yellow">Отправить</a>
            </div>
        </div>
    </div>
</div>