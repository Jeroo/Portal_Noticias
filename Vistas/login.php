   <?php
    
        include 'cabeza.php';
       // include '../controladores/ControladorLogin.php';
    ?>

  <style>
    body {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }

    main {
      flex: 1 0 auto;
    }

    body {
      background: #fff;
    }

    .input-field input[type=date]:focus + label,
    .input-field input[type=text]:focus + label,
    .input-field input[type=email]:focus + label,
    .input-field input[type=password]:focus + label {
      color: #e91e63;
    }

    .input-field input[type=date]:focus,
    .input-field input[type=text]:focus,
    .input-field input[type=email]:focus,
    .input-field input[type=password]:focus {
      border-bottom: 2px solid #e91e63;
      box-shadow: none;
    }
  </style>


  <div class="container">
    <div class="section">

    <div class="section"></div>
  <main>
    <center>
      <img class="responsive-img" src="../recursos/img/logonoticias.PNG"  style="width: 250px;" alt=""/>
      <div class="section"></div>

      <h5 class="indigo-text">Por favor, inicia sesión en tu cuenta</h5>
      <div class="section"></div>

      <div class="container">
        <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

            <form class="col s12" method="post" enctype="multipart/form-data" action="../controladores/ControladorLogin.php">
            <div class='row'>
              <div class='col s12'>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                  <input class='validate' type='text' name='usuario' id='usuario' />
                <label for='usuario'>Ingrese su usuario</label>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type='password' name='clave' id='clave' />
                <label for='clave'>Ingresa tu contraseña</label>
              </div>
            </div>

            <br />
            <center>
              <div class='row'>
                <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect indigo'>Login</button>
              </div>
            </center>
          </form>
        </div>
      </div>
    </center>

    <div class="section"></div>
    <div class="section"></div>
  </main>

    </div>
    <br><br>
  </div>

     
    <?php
    
        include 'pie.php';
    ?>