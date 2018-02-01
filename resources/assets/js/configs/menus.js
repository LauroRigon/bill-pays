export default [
	{
		title: 'Dashboard',
		icon: 'dashboard',
		uri: {
			name: 'dashboard.index'
		}
	},
	{
		title: 'Usuários',
		icon: 'account_circle',
		uri: {
			name: 'users'
		}
	},
	{
		title: 'Clientes',
		icon: 'assignment_ind',
		uri: {
			name: 'clients'
		}
	},
	{
		title: 'Contas',
		icon: 'attach_money',
		items: [
			{
				title: 'Lançar contas',
				icon: 'mdi-credit-card-plus',
				uri: {
					name: 'bills.create'
				}
			},
			{
				title: 'Tipos',
				icon: 'line_weight',
				uri: {
					name: 'bills.types'
				}
			},
			{
				title: 'Procurar contas',
				icon: 'search',
				uri: {
					name: 'bills.filter'
				}
			}
		]
	}
]