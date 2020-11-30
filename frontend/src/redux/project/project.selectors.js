export const myProjectListUser = state => state.projects // should already be filtered for us, at least thats how the initial query will be set up

export const myProjectListClient = (state, clientId) => state.projects.filter(project => project.clientid === clientId) // this will be used when we view a client so a project view might benefit from this, especially since we wont be using this for actually displaying aside from the name and possibly due date

export const selectProject = state => state.selectedProject

export const selectEditing = state => state.isEditing

export const selectCreating = state => state.isCreating

export const projectDetails = (state, id) => state.projects.find(e => e.id === id) ? state.projects.find(e => e.id === id) : null

