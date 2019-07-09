import React from 'react';
import 'bootstrap';


class ListItem extends React.Component
{

    constructor(props)
    {
        super(props);

        this.state = ({
           rights: [],
        });


        this.checkboxHandler = this.checkboxHandler.bind(this);
        this.fireOnClick = this.fireOnClick.bind(this);
    }

    componentWillReceiveProps(nextProps) {
        // You don't have to do this check first, but it can help prevent an unneeded render
        if(this.props.user.id < 0)
            return false;
        if (nextProps.user.rights !== this.state.rights) {
            this.setState({ rights: nextProps.user.rights });
            console.log('Dratuti');
        }


    }


    getAllChildren(rightName)
    {
        let result = [];
        Object.keys(this.props.hierarchy[rightName].children).forEach((item)=>{
            if(result.indexOf(item) < 0){
                result.push(item);
                result.push(...this.getAllChildren(item));
            }

        });

        return result;
    }

    isParentTurnedOn(rightName)
    {
        let result = false;
        Array.from(this.state.rights).forEach((item) => {
            let children = this.props.hierarchy[item].children;
            if(Object.keys(children).indexOf(rightName) >= 0){
                result = true;
            }
        });

        return result;
    }

    addItem(rightName)
    {
        if(this.state.rights.indexOf(rightName) < 0){
            this.setState((state) => {
                let newRights = [...state.rights, rightName, ...this.getAllChildren(rightName)];
                newRights = newRights.filter((value, index) => {
                    return index == newRights.indexOf(value);
                });
                return {rights: newRights}
            }, () => {
                this.fireOnChange();
            });
        }
    }

    deleteItem(rightName)
    {

        this.setState((state) =>{
            let newState = {...state};
            let position = newState.rights.indexOf(rightName);
            if(position >= 0){
                newState.rights.splice(position, 1);
                return newState;
            }
        }, () => {
                this.fireOnChange("DELETE")
            })

    }

    checkboxHandler(event)
    {
        let signature = event.target.getAttribute('data-signature');
        if(event.target.checked){
            this.addItem(signature);
        }
        else{
            if(!this.isParentTurnedOn(signature)){
                this.deleteItem(signature);
            }
        }

    }


    fireOnChange(type="ADD")
    {
        this.props.onChange(this.props.user.id, this.state.rights, type);
    }

    fireOnClick()
    {
        this.props.onUserClick(this.props.user.id);
    }


    render(){
        let hierarchy = this.props.hierarchy;
        return (
            <tr className={this.props.selected ? "table-dark" : ""}>
            <td key="username" onClick={this.fireOnClick}>{this.props.children}</td>
            {Object.keys(hierarchy).map((key) => {
                let inputName = `user[${this.props.user.id}][rights][${key}]`;
                return(
                    <td key={key}>
                        <input type="checkbox"
                               name={inputName}
                               checked={this.state.rights.indexOf(key) >= 0}
                               data-signature={key}
                               disabled={this.isParentTurnedOn(key)}
                               onChange={this.checkboxHandler}
                        />
                    </td>
                )
            })}
            </tr>
        );
    }
}

export default ListItem;