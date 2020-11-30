import React from 'react'
import { connect } from 'react-redux'
import { grabClientDetails } from '../../../redux/client/client.selectors'
import { selectProject } from '../../../redux/project/project.selectors'
import { deselectProject } from '../../../redux/project/project.actions'
import * as MilestoneSelectors from '../../../redux/milestone/milestone.selectors'
import * as MilestoneActions from '../../../redux/milestone/milestone.actions'
import * as TaskSelectors from '../../../redux/task/task.selectors'
import * as TaskActions from '../../../redux/task/task.actions'

import Modal from '../../Modal/Modal'
import Backdrop from '../../Backdrop/Backdrop'

const mapStateToProps = state => ({
  selectedProject: selectProject(state),
  tasksProj: TaskSelectors.myTaskListProject(state, selectProject(state).id),
  tasksMile: id => TaskSelectors.myTaskListMilestone(state, id),
  milestones: MilestoneSelectors.myMilestoneList(state),
  milestoneIsEditing: MilestoneSelectors.selectEditing(state),
  milestoneIsCreating: MilestoneSelectors.selectCreating(state),
  taskIsEditing: TaskSelectors.selectEditing(state),
  taskIsCreating: TaskSelectors.selectCreating(state),
  selectedMilestone: MilestoneSelectors.selectMilestone(state),
  selectedTask: TaskSelectors.selectTask(state),
  grabMilestoneDetails: id => MilestoneSelectors.milestoneDetails(state, id),
  grabClientDetails: id => grabClientDetails(state, id)
})

const mapDispatchToProps = dispatch => ({
  deselectProject: () => dispatch(deselectProject()),
  startMilestoneCreate: () => dispatch(MilestoneActions.startCreate()),
  createMilestone: milestoneData => dispatch(MilestoneActions.addMilestone(milestoneData)),
  stopMilestoneCreate: () => dispatch(MilestoneActions.stopCreate()),
  startMilestoneEdit: id => dispatch(MilestoneActions.startEdit(id)),
  editMilestone: milestoneData => dispatch(MilestoneActions.editMilestone(milestoneData)),
  stopMilestoneEdit: () => dispatch(MilestoneActions.stopEdit()),
  deleteMilestone: id => dispatch(MilestoneActions.deleteMilestone(id)),
  startTaskCreate: () => dispatch(TaskActions.startCreate()),
  createTask: taskData => dispatch(TaskActions.addTask(taskData)),
  stopTaskCreate: () => dispatch(TaskActions.stopCreate()),
  startTaskEdit: id => dispatch(TaskActions.startEdit(id)),
  editTask: taskData => dispatch(TaskActions.editTask(taskData)),
  stopTaskEdit: () => dispatch(TaskActions.stopEdit()),
  deleteTask: id => dispatch(TaskActions.deleteTask(id)),
  selectTask: id => dispatch(TaskActions.selectTask(id))
})

class ProjectDetails extends React.Component {
  constructor(props) {
    super(props)
    this.milestonenameRef = React.createRef()
    this.milestoneduedateRef = React.createRef()
    this.taskmilestoneRef = React.createRef()
    this.tasktitleRef = React.createRef()
    this.taskdescriptionRef = React.createRef()
    this.taskcompletedRef = React.createRef()
  }

  state = {
    activeTab: 'Tasks' // can also be 'Milestones'
  }

  switchTab = tab => {
    this.setState({ activeTab: tab })
  }

  addMilestone = () => {
    const milestoneToAdd = {
      creatorid: 1,
      projectid: this.props.selectedProject.id,
      milestonename: this.milestonenameRef.current.value,
      duedate: this.milestoneduedateRef.current.value
    }

    this.props.createMilestone(milestoneToAdd)
  }

  editMilestone = () => {
    const milestoneToEdit = {
      creatorid: 1,
      projectid: this.props.selectedProject.id,
      milestonename: this.milestonenameRef.current.value,
      duedate: this.milestoneduedateRef.current.value
    }

    this.props.editMilestone(milestoneToEdit)
  }

  addTask = () => {
    const taskToAdd = {
      creatorid: 1,
      projectid: this.props.selectedProject.id,
      milestoneid: this.taskmilestoneRef.current.value,
      title: this.tasktitleRef.current.value,
      description: this.taskdescriptionRef.current.value
    }

    this.props.createTask(taskToAdd)
  }

  editTask = () => {
    const taskToEdit = {
      projectid: this.props.selectedProject.id,
      milestoneid: this.taskmilestoneRef.current.value,
      title: this.tasktitleRef.current.value,
      description: this.taskdescriptionRef.current.value,
      completed: this.taskcompletedRef.current.checked ? 1 : 0
    }

    this.props.editTask(taskToEdit)
  }

  toggleComplete = id => {
    this.props.selectTask(id)
    this.props.editTask({
      ...this.props.selectedTask,
      completed: this.taskcompletedRef ? 1 : 0
    })
    this.props.deselectTask()
  }

  render() {
    return (
      <div>
        {(this.props.milesoneIsEditing || this.props.milesoneIsCreating || this.props.taskIsEditing || this.props.taskIsCreating) && <Backdrop />}
        {
          (this.props.taskIsCreating) &&
          <Modal
            title="Add Task"
            canCancel
            canConfirm
            onCancel={this.props.stopTaskCreate}
            onConfirm={this.addTask}
            ConfirmText="Add"
            CancelText="Cancel"
          >
            <form>
              <div className="form-control">
                <label htmlFor="title">Title</label>
                <input type="text" id="taskTitle" name="title" ref={this.tasktitleRef} required />
              </div>
              <div className="form-control">
                <label htmlFor="description">Description</label>
                <input type="text" name="description" id="taskDescription" ref={this.taskdescriptionRef} required />
              </div>
              <div className="form-control">
                <label htmlFor="milestones">Milestone:</label>
                <select name="milestones" ref={this.taskmilestoneRef}>
                  <option value="null" selected></option>
                  {this.props.milestones.map(milestone => <option value={milestone.id}>{milestone.milestonename}</option>)}
                </select>
              </div>
            </form>
          </Modal>
        }

        {
          (this.props.taskIsEditing && this.props.selectedTask) &&
          <Modal
            title="Edit Task"
            canCancel
            canConfirm
            onCancel={this.props.stopMilestoneEdit}
            onConfirm={this.editMilestone}
            ConfirmText="Save"
            CancelText="Cancel"
          >
            <form>
              <div className="form-control">
                <label htmlFor="title">Title</label>
                <input type="text" id="taskTitle" name="title" defaultValue={this.props.selectedTask.title} ref={this.tasktitleRef} required />
              </div>
              <div className="form-control">
                <label htmlFor="description">Description</label>
                <input type="text" name="description" id="taskDescription" ref={this.taskdescriptionRef} defaultValue={this.props.selectedTask.title} required />
              </div>
              <div className="form-control">
                <label htmlFor="milestones">Milestone:</label>
                <select name="milestones" ref={this.taskmilestoneRef}>
                  <option value="null" selected></option>
                  {this.props.milestones.map(milestone => <option value={milestone.id}>{milestone.milestonename}</option>)}
                </select>
              </div>
              <div className="form-control">
                <label htmlFor="completed">Completed?</label>
                <input type="checkbox" name="completed" id="taskCompleted" defaultChecked={this.props.selectedTask.completed} ref={this.taskdescriptionRef} required />
              </div>
            </form>
          </Modal>
        }
        {
          (this.props.milestoneIsCreating) &&
          <Modal
            title="Add Task"
            canCancel
            canConfirm
            onCancel={this.props.stopTaskCreate}
            onConfirm={this.addTask}
            ConfirmText="Add"
            CancelText="Cancel"
          >
            <form>
              <div className="form-control">
                <label htmlFor="title">Name</label>
                <input type="text" id="taskTitle" name="title" ref={this.milestonenameRef} required />
              </div>
              <div className="form-control">
                <label htmlFor="description">Due Date</label>
                <input type="datetime" name="description" id="taskDescription" ref={this.milestoneduedateRef} required />
              </div>
            </form>
          </Modal>
        }

        {
          (this.props.milestoneIsEditing && this.props.selectedMilestone) &&
          <Modal
            title="Edit Task"
            canCancel
            canConfirm
            onCancel={this.props.stopTaskEdit}
            onConfirm={this.editTask}
            ConfirmText="Save"
            CancelText="Cancel"
          >
            <form>
              <div className="form-control">
                <label htmlFor="title">Name</label>
                <input type="text" id="taskTitle" name="title" ref={this.milestonenameRef} required />
              </div>
              <div className="form-control">
                <label htmlFor="description">Due Date</label>
                <input type="datetime" name="description" id="taskDescription" ref={this.milestoneduedateRef} required />
              </div>
            </form>
          </Modal>
        }
        <div>
          <h1>{this.props.selectedProject.name}</h1>
          <h2>{this.props.selectProject.description}</h2>
          <h2>Due: {this.props.selectedProject.duedate ? this.props.selectedProject.duedate : "No Due Date Set"}</h2>
          <h2>Payment Type: {this.props.selectedProject.paymenttype}</h2>
          <h2>Estimated Hours: {this.props.selectedProject.estimatedhours}</h2>
          <h2>Client: {props.grabClientDetails(this.props.selectedProject.clientid).name}</h2>
        </div>
        <div>
          <div>
            <button onClick={this.props.startMilestoneCreate}>Add Milestone</button>
            <button onClick={this.props.startTaskCreate}>Add Task</button>
          </div>
          <div>
            <a href="" onClick={this.switchTab('Tasks')}>Tasks</a>
            <a href="" onClick={this.switchTab('Milestones')}>Milestones</a>
          </div>
          <div>
            {this.state.activeTab === 'Tasks' ?
              <div>
                {
                  this.props.tasksProj.map(task => {
                    return (
                      <div>
                        <h2>{task.title}</h2>
                        <h3>{task.description}</h3>
                        <h3>{this.props.grabMilestoneDetails(task.id).milestonename ? this.props.grabMilestoneDetails(task.id).milestonename : ""}</h3>
                        <button onClick={this.props.startTaskEdit.bind(this, task.id)}>Edit</button>
                        <button onClick={this.props.deleteTask.bind(this, task.id)}>Delete</button>
                        <input type="checkbox" defaultChecked={task.completed} ref={this.taskcompletedRef} onChange={this.toggleComplete.bind(this, task.id)} />
                      </div>
                    )
                  })
                }
              </div>
              :
              <div>
                {
                  this.props.milestones.map(milestone => {
                    return (
                      <div>
                        <h2>{milestone.milestonename}</h2>
                        <h2>Due {milestone.duedate ? milestone.duedate : "No Due Date Set"}</h2>
                        <button onClick={this.props.startMilestoneEdit.bind(this, milestone.id)}>Edit</button>
                        <button onClick={this.props.deleteMilestone.bind(this, milestone.id)}>Delete</button>
                        {
                          this.props.tasksMile(milestone.id) ?
                            this.props.tasksMile(milestone.id).map(task => {
                              return (
                                <div>
                                  <h2>{task.title}</h2>
                                  <h3>{task.description}</h3>
                                  <button onClick={this.props.startTaskEdit.bind(this, task.id)}>Edit</button>
                                  <button onClick={this.props.deleteTask.bind(this, task.id)}>Delete</button>
                                  <input type="checkbox" defaultChecked={task.completed} ref={this.taskcompletedRef} onChange={this.toggleComplete.bind(this, task.id)} />
                                </div>
                              )
                            })
                            :
                            <h3>No Tasks For This Milestone Yet</h3>
                        }
                        <h2>Other Tasks</h2>
                        {
                          this.props.tasksMile(null).map(task => {
                            return (
                              <div>
                                <h2>{task.title}</h2>
                                <h3>{task.description}</h3>
                                <button onClick={this.props.startTaskEdit.bind(this, task.id)}>Edit</button>
                                <button onClick={this.props.deleteTask.bind(this, task.id)}>Delete</button>
                                <input type="checkbox" defaultChecked={task.completed} ref={this.taskcompletedRef} onChange={this.toggleComplete.bind(this, task.id)} />
                              </div>
                            )
                          })
                        }
                      </div>
                    )
                  })
                }
              </div>
            }
          </div>
        </div>
      </div >
    )
  }
}

export default connect(mapStateToProps, mapDispatchToProps)(ProjectDetails)