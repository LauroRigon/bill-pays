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
				icon: 'attach_money',
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
				icon: 'attach_money',
				uri: {
					name: 'bills.filter'
				}
			}
		]
	}
]