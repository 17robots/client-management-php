import { ADD_PROJECT, EDIT_PROJECT, REMOVE_PROJECT, START_CREATE, STOP_CREATE, START_EDIT, STOP_EDIT, SELECT_PROJECT, DESELECT_PROJECT, FETCH_PROJECTS } from './project.types'

export const startCreate = () => ({
  type: START_CREATE
})
export const addProject = newProject => ({
  type: ADD_PROJECT,
  ...newProject
})

export const stopCreate = () => ({
  type: STOP_CREATE
})

export const startEdit = id => ({
  type: START_EDIT,
  id
})

export const editProject = newProject => ({
  type: EDIT_PROJECT,
  ...newProject
})

export const stopEdit = () => ({
  type: STOP_EDIT
})

export const deleteProject = () => ({
  type: REMOVE_PROJECT
})

export const selectProject = id => ({
  type: SELECT_PROJECT,
  id
})

export const deselectProject = () => ({
  type: DESELECT_PROJECT
})

export const fetchProjects = options => ({
  type: FETCH_PROJECTS,
  options
})