import { ADD_MILESTONE, REMOVE_MILESTONE, EDIT_MILESTONE, START_CREATE, STOP_CREATE, START_EDIT, STOP_EDIT, SELECT_MILESTONE, DESELECT_MILESTONE, FETCH_MILESTONES } from './milestone.types'

export const addMilestone = newData => ({
  type: ADD_MILESTONE,
  ...newData
})

export const editMilestone = newData => ({
  type: EDIT_MILESTONE,
  ...newData
})

export const deleteMilestone = id => ({
  type: REMOVE_MILESTONE,
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

export const selectMilestone = id => ({
  type: SELECT_MILESTONE,
  id
})

export const deselectMilestone = () => ({
  type: DESELECT_MILESTONE
})

export const fetchMilestones = options => ({
  type: FETCH_MILESTONES,
  options
})