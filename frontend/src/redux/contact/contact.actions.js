import { ADD_CONTACT, REMOVE_CONTACT, EDIT_CONTACT, START_CREATE, STOP_CREATE, START_EDIT, STOP_EDIT, SELECT_CONTACT, DESELECT_CONTACT, FETCH_CONTACTS } from './contact.types'

export const addContact = newData => ({
  type: ADD_CONTACT,
  ...newData
})

export const editContact = newData => ({
  type: EDIT_CONTACT,
  ...newData
})

export const deleteContact = id => ({
  type: REMOVE_CONTACT,
  id
})

export const startCreate = () => ({
  type: START_CREATE
})

export const stopCreate = () => ({
  type: STOP_CREATE
})

export const startEdit = id => ({
  type: START_EDIT,
  id
})

export const stopEdit = () => ({
  type: STOP_EDIT
})

export const selectContact = id => ({
  type: SELECT_CONTACT,
  id
})

export const deselectContact = () => ({
  type: DESELECT_CONTACT
})

export const fetchContacts = options => ({
  type: FETCH_CONTACTS,
  options
})