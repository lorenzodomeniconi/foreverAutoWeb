<div class="container my-5">
    <h2 class="text-light mb-4">Le tue notifiche</h2>

    <?php if (count($templateParams["notifiche"]) > 0): ?>
        <div class="row">
            <?php foreach ($templateParams["notifiche"] as $notifica): ?>
                <div class="col-md-6 mb-4">
                    <div class="card custom-bg-card shadow-sm <?php echo $notifica['nuova'] ? 'notifica-nuova' : 'notifica-letta'; ?>">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo date("d/m/Y H:i", strtotime($notifica['dataOra'])); ?></h6>
                            <p class="card-text text-light mb-2"><?php echo htmlspecialchars($notifica['messaggio']); ?></p>
                            <span class="badge"><?php echo $notifica['nuova'] ? 'Nuova' : 'Letta'; ?></span>

                            <div class="mt-3 d-flex justify-content-end gap-2">
                                <?php if ($notifica['nuova']): ?>
                                    <form action="manageNotifies.php" method="POST">
                                        <input type="hidden" name="codNotifica" value="<?php echo $notifica['codNotifica']; ?>">
                                        <button type="submit" name="segnaLetta" class="btn btn-sm btn-outline-light">Segna come letta</button>
                                    </form>
                                <?php endif; ?>
                                <form action="manageNotifies.php" method="POST">
                                    <input type="hidden" name="codNotifica" value="<?php echo $notifica['codNotifica']; ?>">
                                    <button type="submit" name="elimina" class="btn btn-sm btn-outline-danger">Elimina</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-light">Non hai ancora notifiche.</p>
    <?php endif; ?>
</div>