import { ADD_TASK, REMOVE_TASK, EDIT_TASK, START_CREATE, STOP_CREATE, START_EDIT, STOP_EDIT, SELECT_TASK, DESELECT_TASK, FETCH_TASKS } from './task.types'

export const addTask = newData => ({
  type: ADD_TASK,
  ...newData
})

export const editTask = newData => ({
  type: EDIT_TASK,
  ...newData
})

export const deleteTask = id => ({
  type: REMOVE_TASK,
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

export const selectTask = id => ({
  type: SELECT_TASK,
  id
})

export const deselectTask = () => ({
  type: DESELECT_TASK
})

export const fetchTasks = options => ({
  type: FETCH_TASKS,
  options
})