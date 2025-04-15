<?php require('components/head.php') ?>
<?php require('components/nav.php') ?>

<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">About us</h1>
    </div>
  </header>

  <main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <p>NOTES</p>
      <ul>
        <?php foreach ($notes as $note) : ?>
        
          <li>
          <a href="/demo/index.php?note?id=<?= $note['id']?>" class="text-blue-500">
            <?=  $note['body'] ?>
          </a>
        </li>
      </ul>
        <?php  endforeach; ?>
         <p>
         <a href="/demo/index.php?notes/create" class="text-blue-500 hover:underline">
           Create Note 
          </a>
           
         </p>
    </div>
  </main>
  <?php require('components/footer.php') ?>