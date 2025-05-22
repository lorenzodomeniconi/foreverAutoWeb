<div class="container my-5">
    <h2 class="text-light mb-4">Gestione Parco Auto</h2>

    <?php if (count($templateParams["vehicles"]) > 0): ?>
        <div class="row">
            <?php foreach ($templateParams["vehicles"] as $vehicle): ?>
                <div class="col-md-4 mb-4">
                    <div class="card custom-bg-card shadow-sm">
                        <?php
                            $imgName = strtolower(str_replace(' ', '', $vehicle['marca'] . $vehicle['modello'])) . ".jpeg";
                            $imgPath = "style/vehicleImgs/" . $imgName;
                        ?>

                        <img src="<?php echo $imgPath; ?>" class="card-img-top" 
                            alt="<?php echo strtolower(str_replace(' ', '', $vehicle['marca'] . $vehicle['modello'])) . ".jpeg"; ?>">
                        
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($vehicle['marca'] . " " . $vehicle['modello']); ?></h5>
                            <p class="card-text">Prezzo: € <?php echo number_format($vehicle['prezzo'], 2); ?></p>
                            <p class="card-text">Alimentazione: <?php echo htmlspecialchars($vehicle['alimentazione']); ?></p>
                            <p class="card-text">Kilometri: <?php echo number_format($vehicle['kilometri']); ?> km</p>

                            <div class="d-flex justify-content-end">
                                <a href="vaiAModificavehicle.php?numTelaio=<?php echo $vehicle['numTelaio']; ?>" class="btn btn-sm btn-warning mr-2">Modifica</a>
                                <form action="eliminavehicle.php" method="POST" class="d-inline">
                                    <input type="hidden" name="numTelaio" value="<?php echo $vehicle['numTelaio']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Elimina</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
    <?php else: ?>
        <p class="text-light">Non ci sono veicoli nella tua concessionaria.</p>
    <?php endif; ?>

    <div class="mt-4">
        <a href="aggiungivehicle.php" class="btn btn-primary">Aggiungi nuovo vehicle</a>
    </div>
</div>
