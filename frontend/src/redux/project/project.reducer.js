import { ADD_PROJECT, EDIT_PROJECT, REMOVE_PROJECT, START_CREATE, STOP_CREATE, START_EDIT, STOP_EDIT, SELECT_PROJECT } from './project.types'

const INITIAL_STATE = {
  projects: [],
  isEditing: false,
  isCreating: false,
  selectedProject: null
}

const projectReducer = (state = INITIAL_STATE, action) => {
  switch (action.type) {
    case START_CREATE:
      return {
        ...state,
        isCreating: true
      }
    case STOP_CREATE:
      return {
        ...state,
        isCreating: false
      }
    case START_EDIT:
      const selectedProject = state.projects.find(e => e.id === action.id)
      return {
        ...state,
        isEditing: true,
        selectedProject
      }
    case STOP_EDIT:
      return {
        ...state,
        isEditing: false,
        selectedProject: null
      }
    case ADD_PROJECT:
      const updatedProjects = [...state.projects]
      // lets make the request
      const body = {
        action: "addProject",
        creatorid: action.creator,
        clientid: action.clientid,
        name: action.name,
        description: action.description,
        estimatedhours: action.estimatedhours,
        rate: rate,
        paymenttype: action.paymenttype,
        duedate: duedate
      }

      fetch('https://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json)
        .then(resData => {
          if (resData.error) {
            console.log(resData.error)
            return state
          } else {
            updatedProjects.push({
              ...resData
            })
          }
        })
      return {
        ...state,
        isCreating: false,
        projects: updatedProjects
      }
    case EDIT_PROJECT:
      const updatedProjects = [...state.projects]
      // lets make the request
      const body = {
        action: "updateProject",
        ...action
      }

      fetch('https://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json)
        .then(resData => {
          if (resData.error) {
            console.log(error)
            return state
          } else {
            updatedProjects[state.projects.indexOf(state.projects.find(e => e.id === state.selectedProject.id))] = {
              ...updatedProjects[state.projects.indexOf(state.projects.find(e => e.id === state.selectedProject.id))],
              ...action
            }
          }
        })
      return {
        ...state,
        projects: updatedProjects,
        isEditing: false,
        selectedProject: false
      }
    case SELECT_PROJECT:
      const selectedProject = state.projects.find(e => e.id === action.id)
      return {
        ...state,
        selectedProject
      }
  }
}

export default projectReducer