<div class="modal fade" id="addCakeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Cake Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addCakeForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Cake Type</label>
                        <input type="text" name="type" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Initial Size (inches)</label>
                        <input type="number" name="size" class="form-control" required min="1" step="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price (RM)</label>
                        <input type="number" name="price" class="form-control" required min="0" step="0.01">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Cake</button>
                </div>
            </form>
        </div>
    </div>
</div> 