import { ADD_CLIENT, EDIT_CLIENT, REMOVE_CLIENT, START_CREATE, STOP_CREATE, START_EDIT, STOP_EDIT, SELECT_CLIENT, DESELECT_CLIENT, FETCH_CLIENTS } from './client.types'

export const addClient = newClient => ({
  type: ADD_CLIENT,
  ...newClient
})

export const removeClient = id => ({
  type: REMOVE_CLIENT,
  id
})

export const editClient = newData => ({
  type: EDIT_CLIENT,
  ...newData
})

export const startEdit = id => ({
  type: START_EDIT,
  id
})

export const startCreate = () => ({
  type: START_CREATE
})

export const stopCreate = () => ({
  type: STOP_CREATE
})

export const stopEdit = () => ({
  type: STOP_EDIT
})

export const selectClient = id => ({
  type: SELECT_CLIENT,
  id
})

export const deselectClient = () => ({
  type: DESELECT_CLIENT
})

export const fetchClients = options => ({
  type: FETCH_CLIENTS,
  options
})