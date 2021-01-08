export default {
  items: [
    {
      name: 'Dashboard',
      url: '/dashboard',
      icon: 'icon-speedometer'
    },
    {
      name: 'References',
      url: '/references',
      icon: 'icon-book-open',
      children: [
        {
          name: 'Departments',
          url: '/references/departments',
          icon: 'icon-list'
        },
        {
          name: 'Categories',
          url: '/references/categories',
          icon: 'icon-list'
        },
        {
          name: 'Units',
          url: '/references/units',
          icon: 'icon-list'
        },
        {
          name: 'Card Types',
          url: '/references/cardtypes',
          icon: 'icon-list'
        },
        {
          name: 'Check Types',
          url: '/references/checktypes',
          icon: 'icon-list'
        },
        {
          name: 'GC Types',
          url: '/references/gctypes',
          icon: 'icon-list'
        },
        {
          name: 'Discount Types',
          url: '/references/discounttypes',
          icon: 'icon-list'
        },
        {
          name: 'Suppliers',
          url: '/references/suppliers',
          icon: 'icon-list'
        },
        {
          name: 'Products',
          url: '/references/products',
          icon: 'icon-list'
        },
      ]
    },
    {
      name: 'Inventory',
      url: '/inventory',
      icon: 'icon-book-open',
      children: [
        {
          name: 'Purchase Order List',
          url: '/inventory/purchaseorderlists',
          icon: 'icon-list'
        },
        {
          name: 'Receiving List',
          url: '/inventory/receivinglists',
          icon: 'icon-list'
        },
        {
          name: 'Issuance List',
          url: '/inventory/issuance',
          icon: 'icon-list'
        },
        {
          name: 'Adjustment List',
          url: '/inventory/adjustmentlists',
          icon: 'icon-list'
        },
      ]
    },
    {
      name: 'Accounts',
      url: '/accounts',
      icon: 'icon-wrench',
      rights: [10, 11, 12],
      children: [
        {
          name: 'Users',
          url: '/accounts/users',
          rights: '10-37',
          icon: 'icon-user'
        },
        {
          name: 'User Group',
          url: '/accounts/user_groups',
          rights: '11-41',
          icon: 'icon-people'
        },
        {
          name: 'Company Settings',
          url: '/accounts/company_settings',
          rights: '12-45',
          icon: 'icon-settings'
        }
      ]
    },
  ],
}
