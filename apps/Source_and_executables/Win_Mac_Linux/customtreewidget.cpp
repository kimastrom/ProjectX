// Subclass for handling some key events for the list with populated snippets

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include "customtreewidget.h"
#include <QTreeWidgetItemIterator>
#include <QTreeWidget>

// Constructor
CustomTreeWidget::CustomTreeWidget(QWidget *a_parent) {}

// Handling keypress events for the list of populated snippets, so the user can switch between
// snippets with the up and down arrowkeys. The user can even show or hide snippets in a category with
// left and right arrowkeys
void CustomTreeWidget::keyPressEvent(QKeyEvent *a_event)
{
    // Let the user move to the next item up in the list,
    // and show the selected snippet
    if (a_event->key() == Qt::Key_Up)
    {
        setCurrentIndex(indexAbove(currentIndex()));

        // If the selection is inside the list,
        // send a mouseclick to the item and
        // show its snippet
        if (this->currentItem() != 0)
        {
            emit clicked(currentIndex());
        }
        // If selection goes outside the tree, return
        // the selection to the first item in list
        else
        {
            QTreeWidgetItemIterator item (this);
            this->setCurrentItem(*item);
        }
    }
    // Let the user move to the next item down the list,
    // and show the selected snippet
    else if (a_event->key() == Qt::Key_Down)
    {
        setCurrentIndex(indexBelow(currentIndex()));

        // If the selection is inside the list,
        // send a mouseclick to the item and
        // show its snippet
        if (this->currentItem() != 0)
        {
            emit clicked(currentIndex());
        }
        // If selection goes outside the tree, return
        // the selection to the first item in list
        else
        {
            QTreeWidgetItemIterator item (this);
            this->setCurrentItem(*item);
        }
    }
    // Let the user show a languagecategory with
    // snippets, with help of the left arrow key
    else if (a_event->key() == Qt::Key_Left)
    {
        // Do the thing, if the selection is in the list
        if (this->currentItem() != 0)
        {
            this->currentItem()->setExpanded(false);
        }
    }
    // Let the user hide a languagecategory with
    // snippets, with help of the right arrow key
    else if (a_event->key() == Qt::Key_Right)
    {
        // Do the thing, if the selection is in the list
        if (this->currentItem() != 0)
        {
            this->currentItem()->setExpanded(true);
        }
    }
}
