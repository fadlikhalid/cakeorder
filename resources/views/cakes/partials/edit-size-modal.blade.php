<div class="modal fade" id="editSizeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Price</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSizeForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editSizeId" name="size_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Size</label>
                        <input type="text" id="editSize" class="form-control" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price (RM)</label>
                        <input type="number" name="price" id="editPrice" class="form-control" required min="0" step="0.01">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Price</button>
                </div>
            </form>
        </div>
    </div>
</div> 