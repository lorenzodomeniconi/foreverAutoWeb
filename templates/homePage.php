<div class="search-wrapper my-4">
  <form class="d-flex" action="index.php" method="GET">
    <input class="form-control dark-input flex-grow-1 me-2" type="search" name="search" placeholder="Cerca veicolo..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" aria-label="Search">
    <button class="btn btn-search" type="submit">Cerca</button>
  </form>
</div>

<div class="filter-wrapper my-4">
  <form class="d-flex flex-wrap justify-content-center gap-3" action="index.php" method="GET">
    <select class="form-select filter-dark" name="categoria">
      <option value="">Tutte le categorie</option>
      <?php foreach($templateParams['categories'] as $category): ?>
        <option value="<?php echo htmlspecialchars($category['tipo']); ?>" <?php if(isset($_GET['categoria']) && $_GET['categoria'] == $categoria['tipo']) echo 'selected'; ?>>
          <?php echo htmlspecialchars($category['tipo']); ?>
        </option>
      <?php endforeach; ?>
    </select>

    <select class="form-select filter-dark" name="disponibilita">
      <option value="">Qualsiasi stato</option>
      <option value="0" <?php if(isset($_GET['disponibilita']) && $_GET['disponibilita'] === "0") echo 'selected'; ?>>Disponibile</option>
      <option value="1" <?php if(isset($_GET['disponibilita']) && $_GET['disponibilita'] === "1") echo 'selected'; ?>>Venduto</option>
    </select>

    <button class="btn btn-search" type="submit">Filtra</button>
  </form>
</div>

<div class="container my-4">
  <div class="row justify-content-center">
    <?php if(count($templateParams['vehicles']) > 0): ?>
      <?php foreach($templateParams['vehicles'] as $vehicle): ?>
        <div class="col-md-4 col-lg-3 mb-4">
          <a href="veicolo.php?telaio=<?php echo urlencode($vehicle['numTelaio']); ?>" class="text-decoration-none">
            <div class="card card-hover custom-bg-card text-white h-100 shadow-lg">
            <?php
                $nomeImmagine = strtolower(str_replace(' ', '', $vehicle['marca'] . $vehicle['modello'])) . ".jpeg";
                $percorsoImmagine = "style/vehicleImgs/" . $nomeImmagine;
              ?>
              
              <img src="<?php echo $percorsoImmagine; ?>" class="card-img-top" alt="<?php echo strtolower(str_replace(' ', '', $vehicle['marca'] . $vehicle['modello'])) . ".jpeg"; ?>">

              <div class="card-body d-flex flex-column">
                <h5 class="card-title">
                  <?php echo htmlspecialchars($vehicle['marca']) . " " . htmlspecialchars($vehicle['modello']); ?>
                </h5>
                <p class="card-text mb-1"><strong>Alimentazione:</strong> <?php echo htmlspecialchars($vehicle['alimentazione']); ?></p>
                <p class="card-text mb-1"><strong>Kilometri:</strong> <?php echo number_format($vehicle['kilometri']); ?></p>
                <p class="card-text mb-1"><strong>Prezzo:</strong> € <?php echo number_format($vehicle['prezzo'], 2); ?></p>
                <span class="badge <?php echo $vehicle['venduto'] ? 'bg-danger' : 'bg-success'; ?> mt-auto">
                  <?php echo $vehicle['venduto'] ? 'Venduto' : 'Disponibile'; ?>
                </span>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12">
        <p class="text-center text-light">Nessun veicolo trovato con i criteri selezionati.</p>
      </div>
    <?php endif; ?>
  </div>
</div>
