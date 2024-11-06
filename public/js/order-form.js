let printModal;

document.addEventListener('DOMContentLoaded', function() {
    console.log('Script loaded');

    const cakeTypeSelect = document.getElementById('cakeTypeSelect');
    const sizeSelect = document.querySelector('select[name="size_id"]');
    
    console.log('Elements found:', { 
        cakeTypeSelect: !!cakeTypeSelect, 
        sizeSelect: !!sizeSelect 
    });

    if (cakeTypeSelect) {
        cakeTypeSelect.addEventListener('change', async function() {
            const cakeId = this.value;
            console.log('Cake selected:', cakeId);

            if (!cakeId) {
                sizeSelect.innerHTML = '<option value="">Select Size</option>';
                return;
            }

            try {
                const response = await fetch(`/get-cake-sizes/${cakeId}`);
                console.log('Response status:', response.status);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const sizes = await response.json();
                console.log('Sizes received:', sizes);

                sizeSelect.innerHTML = '<option value="">Select Size</option>';
                sizes.forEach(size => {
                    const option = document.createElement('option');
                    option.value = size.id;
                    option.textContent = `${size.size}" - RM${size.price}`;
                    sizeSelect.appendChild(option);
                });

            } catch (error) {
                console.error('Error fetching sizes:', error);
                sizeSelect.innerHTML = '<option value="">Error loading sizes</option>';
            }
        });
    }

    printModal = new bootstrap.Modal(document.getElementById('printModal'));
    
    const orderForm = document.getElementById('orderForm');
    
    if (orderForm) {
        orderForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errors => Promise.reject(errors));
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.orderIdToPrint = data.order.id;
                    printModal.show();
                }
            })
            .catch(errors => {
                console.error('Validation errors:', errors);
                
                document.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                
                if (errors.errors) {
                    Object.keys(errors.errors).forEach(field => {
                        const fieldMap = {
                            'cake_type': 'cake_id',
                            'size': 'size_id'
                        };
                        
                        const formField = fieldMap[field] || field;
                        const input = document.querySelector(`[name="${formField}"]`);
                        
                        if (input) {
                            input.classList.add('is-invalid');
                            const feedback = input.nextElementSibling;
                            if (feedback && feedback.classList.contains('invalid-feedback')) {
                                feedback.textContent = errors.errors[field][0];
                            }
                        }
                    });
                }
                
                Toastify({
                    text: "Please check the form for errors",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#EF4444",
                    stopOnFocus: true
                }).showToast();
            });
        });
    }
});

function printOrder() {
    if (window.orderIdToPrint) {
        window.open(`/orders/${window.orderIdToPrint}/print`, '_blank');
    }
    redirectToIndex();
}

function skipPrint() {
    redirectToIndex();
}

function redirectToIndex() {
    printModal.hide();
    window.location.href = indexUrl;
}
