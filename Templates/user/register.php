<h1>Create user</h1>
<div>
    <?php if($error = error()): ?>
        <div class="alert alert-danger" role="alert">
            <?=$error['message']?>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <label class="col-sm-2 col-form-label">Имя</label>
                    <label class="col-sm-10 col-form-label">
                        <?=$error['data']['user']['name']?>
                    </label>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <label class="col-sm-10  col-form-label">
                        <?=$error['data']['user']['email']?>
                    </label>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">Город</label>
                    <label class="col-sm-10  col-form-label">
                        <?=$error['data']['user']['territory']?>
                    </label>
                </div>
            </div>
        </div>
    <?php endif ?>
    <form action="/user/create" method="POST">
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Имя</label>
            <div class="col-sm-10">
                <input name="name" required type="text" class="form-control" id="name" placeholder="Имя">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input name="email" required type="email" class="form-control" id="email" placeholder="example@gmail.com">
            </div>
        </div>
        <div class="form-group row">
            <label for="region" class="col-sm-2 col-form-label">Город</label>
            <div class="col-sm-10">
                <select required id="region" data-placeholder="Выберите область">
                    <option></option>
                    <?php foreach ($regions as $region): ?>
                        <option value="<?=$region->ter_id?>"><?=$region->ter_name?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div id="city-container" class="form-group row" style="display: none" >
            <label for="city" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <select required id="city" data-placeholder="Выберите город">

                </select>
            </div>
        </div>
        <div id="locality-container" class="form-group row" style="display: none" >
            <label for="locality" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <select id="locality" data-placeholder="Выберите район | населенный пункт">

                </select>
            </div>
        </div>
        <div id="town-container" class="form-group row" style="display: none"  >
            <label for="town" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <select id="town" data-placeholder="Выберите населенный пункт">

                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>

    </form>
</div>
