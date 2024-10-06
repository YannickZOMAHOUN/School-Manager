<!-- resources/views/modals/delete.blade.php -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-color-avt" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.</p>
                <form id="deleteForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger ms-2">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\School-Manager\resources\views/modals/delete.blade.php ENDPATH**/ ?>