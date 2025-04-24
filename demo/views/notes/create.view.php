<?php require($_SERVER['DOCUMENT_ROOT'] . '/demo/views/components/head.php') ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/demo/views/components/nav.php') ?>

<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">About us</h1>
    </div>
  </header>

  <main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <p>NOTES</p>
        <form  action="index.php?notes/create" method="POST">

          <label for="body"  require> Escreve aqui</label>

          
          <textarea  name="text"></textarea>

          </div>
         

           <p>
            <button  type="submit">
              Create
            </button>
           </p>

        </form>
    </div>
  </main>
  <?php require($_SERVER['DOCUMENT_ROOT'] . '/demo/views/components/footer.php') ?>