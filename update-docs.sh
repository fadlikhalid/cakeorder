# Create the docs directory if it doesn't exist
mkdir -p docs

# Create or update styling-guide.md
cat > docs/styling-guide.md << 'EOL'
# Cake Order Management System - Styling Guide

## Core Styles

### Colors
- Primary: #4f46e5 (Indigo) - Main actions, buttons
- Secondary: #6b7280 (Gray) - Text, icons
- Success: #10B981 (Green) - Success states, completed
- Warning: #f59e0b (Orange) - Preparing status
- Danger: #ef4444 (Red) - Delete actions
- Background: #f9fafb - Page background
- Borders: #e5e7eb - Dividers, containers

### Typography
- Font Family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif
- Base Text: 0.875rem (14px)
- Small Text: 0.75rem (12px)
- Headers: 1.25rem (20px)
- Font Weights: 400 (regular), 500 (medium), 600 (semibold)

### Components

#### Navbar
- Fixed top position
- Brand icon with text
- Responsive mobile menu
- Active state indicators

#### Cards
- Consistent padding (1rem)
- Header with icon and title
- Collapsible content
- Action buttons aligned right

#### Buttons
- Icon + Text layout
- Consistent min-width (135px)
- Mobile-responsive sizing
- Clear hover states

#### Forms
- Icon-enhanced inputs
- Clear validation states
- Consistent spacing
- Responsive layouts

### Print Styles
- Clean layout for printing
- Hide unnecessary elements
- Proper page breaks
- Consistent margins

### Responsive Design
- Mobile breakpoint: 576px
- Tablet breakpoint: 768px
- Desktop breakpoint: 992px

Key mobile adaptations:
- Stack horizontal layouts
- Reduce button sizes
- Adjust font sizes
- Full-width inputs
- Collapsible navigation

Last Updated: $(date +"%Y-%m-%d")
Version: 1.1
EOL

# Create or update application-flow.md
cat > docs/application-flow.md << 'EOL'
# Cake Order Management System - Application Flow

## Core Features

### Order Management
1. Create New Order
   - Customer information
   - Cake selection
   - Size selection
   - Delivery details
   - Special instructions
   - Price calculation

2. Order List
   - Filter by date/status
   - Search functionality
   - Status updates
   - Print orders
   - Delete orders

3. Order Details
   - Collapsible view
   - Print preview
   - Status management
   - Edit/Delete options

### Cake Management
1. Cake Types
   - Add new cake types
   - Delete existing types
   - Search functionality

2. Size Management
   - Add sizes to cakes
   - Set/update prices
   - Delete sizes

## User Flows

### Creating an Order
1. Click "New Order" in navigation
2. Fill customer details
3. Select cake type and size
4. Set delivery date/time
5. Add special instructions
6. Submit order
7. Optional: Print order

### Managing Orders
1. View all orders on dashboard
2. Filter/Search as needed
3. Click to expand details
4. Update status as needed
5. Print or delete as required

### Managing Cakes
1. Access Cakes section
2. Add new cake types
3. Add sizes to existing cakes
4. Update prices as needed
5. Remove obsolete items

## Technical Implementation

### Frontend
- Blade templates
- Bootstrap 5 framework
- Custom CSS components
- JavaScript for interactivity
- Toastify for notifications

### Data Flow
1. Form submissions
2. AJAX requests
3. Server validation
4. Database updates
5. Response handling
6. UI updates

### Key Components
- Navigation system
- Filter system
- Modal dialogs
- Print templates
- Status management
- Price calculations

## Future Enhancements
- [ ] Order statistics
- [ ] Customer management
- [ ] Inventory tracking
- [ ] Email notifications
- [ ] Payment integration
- [ ] Mobile app version

Last Updated: $(date +"%Y-%m-%d")
Version: 1.0
EOL

echo "Documentation files have been created/updated in the docs directory!"
