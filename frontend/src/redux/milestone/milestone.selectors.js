export const myMilestoneList = (state, projectId) => state.milestones.filter(milestone => milestone.projectid === projectId)

export const selectMilestone = state => state.selectedMilestone

export const selectEditing = state => state.isEditing

export const selectCreating = state => state.isCreating

export const milestoneDetails = (state, id) => state.milestones.find(e => e.id === id) ? state.find(e => e.id === id) : null
