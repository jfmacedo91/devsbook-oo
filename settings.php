<?php
  require_once 'config.php';
  require_once 'models/Auth.php';
  require_once 'dao/UserDaoMysql.php';

  $auth = new Auth($pdo, $baseURL);
  $user = $auth->checkToken();
  $activeMenu = 'config';

  $userDao = new UserDaoMysql($pdo);

  require 'partials/header.php';
  require 'partials/menu.php';
?>

<section class="feed mt-10">
  <div class="box row">
    <div class="column m-10">
      <h1>Configurações</h1>
      <form class="config-form" action="settings_action.php" enctype="multipart/form-data" method="POST">
        <label>
          Novo avatar:
          <input type="file" name="avatar" />
        </label>

        <label>
          Novo capa:
          <input type="file" name="cover" />
        </label>

        <hr />

        <label>
          Nome completo:
          <input type="text" name="name" value="<?= $user->name; ?>" />
        </label>

        <label>
          Email:
          <input type="email" name="email" value="<?= $user->email; ?>" />
        </label>

        <label>
          Data de nascimento:
          <input type="text" name="birthdate" value="<?= $user->birthdate; ?>" />
        </label>

        <label>
          Cidade:
          <input type="text" name="city" value="<?= $user->city; ?>" />
        </label>

        <label>
          Trabalho:
          <input type="text" name="work" value="<?= $user->work; ?>" />
        </label>

        <hr />

        <label>
          Nova senha:
          <input type="password" name="password" />
        </label>

        <label>
          Confirmar nova senha:
          <input type="password" name="password_confirmation" />
        </label>

        <button type="submit" class="button">Salvar</button>
      </form>
    </div>
  </div>
</section>

<?php require 'partials/footer.php'; ?>