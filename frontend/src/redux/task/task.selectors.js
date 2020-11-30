export const myTaskListProject = (state, projectId) => state.task.tasks.filter(task => task.projectid === projectId)

export const myTaskListMilestone = (state, milestoneId) => state.task.tasks.filter(task => task.milestoneid === milestoneId)

export const selectTask = state => state.task.selectedTask

export const selectEditing = state => state.task.isEditing

export const selectCreating = state => state.task.isCreating

export const taskDetails = (state, id) => state.task.tasks.find(e => e.id === id) ? state.task.tasks.find(e => e.id === id) : null
