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
          <a href="/demo/public/index.php?notes" class="text-blue-500">
            <p>Go back..</p>
          </a>
        
           <p> <?= $note['body'] ?? 'não existe' ?></p>

           <form class="mt-6"  method="post" >
             <input type="hidden" name= 'id' value="<?=$note['id'] ?>">
            <button class="text-sm test-red-500">Delete</button>
           </form>


    </div>
  </main>
  <?php require($_SERVER['DOCUMENT_ROOT'] . '/demo/views/components/footer.php') ?>