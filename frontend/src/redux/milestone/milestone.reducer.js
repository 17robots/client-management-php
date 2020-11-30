import { ADD_MILESTONE, REMOVE_MILESTONE, EDIT_MILESTONE, START_CREATE, STOP_CREATE, START_EDIT, STOP_EDIT, SELECT_MILESTONE, DESELECT_MILESTONE, FETCH_MILESTONES } from './milestone.types'

const INITIAL_STATE = {
  milestones: [],
  selectedMilestone: null,
  isCreating: false,
  isEditing: false
}

export const milestoneReducer = (state = INITIAL_STATE, action) => {
  let body
  let updatedMilestones
  let selectedMilestone

  switch (action.type) {
    case ADD_MILESTONE:
      updatedMilestones = [...state.milestones]
      body = {
        action: "addMilestone",
        creatorid: action.creator,
        projectid: action.project,
        milestonename: action.milestonename,
        duedate: action.duedate
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json())
        .then(resData => {
          if (resData.error) {
            console.log(resData.error)
            return state
          } else {
            updatedMilestones.push({
              id: resData.id,
              creatorId: resData.creatorId,
              projectId: resData.projectId,
              milestonename: resData.milestonename,
              duedate: resData.duedate
            })
          }
        })
      return {
        ...state,
        milestones: updatedMilestones,
        isCreating: false
      }
    case EDIT_MILESTONE:
      updatedMilestones = [...state.milestones]
      body = {
        action: "editMilestone",
        projectid: action.projectid,
        milestonename: action.milestonename,
        duedate: action.duedate
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json())
        .then(resData => {
          if (resData.error) {
            console.log(resData.error)
            return state
          } else {
            updatedMilestones[updatedMilestones.indexOf(updatedMilestones.find(state.selectedMilestone.id))] = {
              ...updatedMilestones[updatedMilestones.indexOf(updatedMilestones.find(state.selectedMilestone.id))],
              projectId: resData.projectId,
              milestonaname: resData.milestonename,
              duedate: resData.datedue
            }
          }
        })
      return {
        ...state,
        milestones: updatedMilestones,
        isEditing: false,
        selectedMilestone: null
      }
    case REMOVE_MILESTONE:
      updatedMilestones = [...state.milestones]
      body = {
        action: "deleteMilestone",
        id: action.id
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json())
        .then(resData => {
          if (resData.success) {
            updatedMilestones = updatedMilestones.filter(item => item.id !== state.selectedMilestone.id)
          } else {
            console.log(resData.error)
            return state
          }
        })
      return {
        ...state,
        milestones: updatedMilestones,
        selectedMilestone: null
      }
    case START_CREATE:
      return {
        ...state,
        isCreating: true,
      }
    case STOP_CREATE:
      return {
        ...state,
        isCreating: false
      }
    case START_EDIT:
      selectedMilestone = state.milestones.find(e => e.id === action.id)
      return {
        ...state,
        isEditing: true,
        selectedMilestone
      }
    case STOP_EDIT:
      return {
        ...state,
        isEditing: false,
        selectedMilestone: null
      }
    case SELECT_MILESTONE:
      selectedMilestone = state.milestones.find(e => e.id === action.id)
      return {
        ...state,
        selectedMilestone
      }
    case DESELECT_MILESTONE:
      return {
        ...state,
        selectedMilestone: null
      }
    case FETCH_MILESTONES:
      let milestones = []
      body = {
        action: "getMilestones",
        options: action.options
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json())
        .then(resData => {
          if (resData.error) {
            console.log(resData.error)
            return state
          } else {
            milestones = resData
          }
        })
      return {
        ...state,
        milestones
      }
    default:
      return state
  }
}
