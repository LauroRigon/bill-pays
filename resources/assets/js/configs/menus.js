export default [
	{
		title: 'Dashboard',
		icon: 'dashboard',
		uri: {
			name: 'dashboard'
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
				title: 'Tipos',
				icon: 'attach_money',
				uri: {
					name: 'bills.types'
				}
			}
		]
	},
	{
		title: 'Configurações',
		icon: 'tal',
		uri: "/configs"
	}
]