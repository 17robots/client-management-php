export const myContactList = (state, clientId) => state.contacts.filter(contact => contact.clientid === clientId)

export const selectContact = state => state.selectContact

export const selectEditing = state => state.isEditing

export const selectCreating = state => state.isCreating

export const contactDetails = (state, id) => state.contacts.find(e => e.id === id) ? state.contacts.find(e => e.id === id) : null
