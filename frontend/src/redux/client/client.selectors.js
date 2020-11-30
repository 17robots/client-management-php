export const myClientList = state => state.clients // this should already be filtered from the query ?

export const selectClient = state => state.selectedClient

export const selectEditing = state => state.isEditing

export const selectCreating = state => state.isCreating

export const clientDetails = (state, id) => state.clients.find(e => e.id === id) ? state.client.client.find(e => e.id === id) : null
