import { ADD_CLIENT, EDIT_CLIENT, REMOVE_CLIENT, START_CREATE, STOP_CREATE, START_EDIT, STOP_EDIT, SELECT_CLIENT, DESELECT_CLIENT } from './client.types'

export const addClient = newClient => {
  return {
    type: ADD_CLIENT,
    ...newClient
  }
}

export const removeClient = id => {
  return {
    type: REMOVE_CLIENT,
    id
  }
}

export const editClient = newData => {
  return {
    type: EDIT_CLIENT,
    ...newData
  }
}

export const startEdit = id => {
  return {
    type: START_EDIT,
    id
  }
}

export const startCreate = () => {
  return {
    type: START_CREATE
  }
}

export const stopCreate = () => {
  return {
    type: STOP_CREATE
  }
}

export const stopEdit = () => {
  return {
    type: STOP_EDIT
  }
}

export const selectClient = id => {
  return {
    type: SELECT_CLIENT,
    id
  }
}

export const deselectClient = () => {
  return {
    type: DESELECT_CLIENT,
  }
}