<div class="modal fade" id="addSizeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Size for <span id="cakeTypeText"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addSizeForm">
                @csrf
                <input type="hidden" id="cakeId" name="cake_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Size (inches)</label>
                        <input type="number" name="size" class="form-control" required min="1" step="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price (RM)</label>
                        <input type="number" name="price" class="form-control" required min="0" step="0.01">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Size</button>
                </div>
            </form>
        </div>
    </div>
</div> 