// Subclass for handling some mouse events for the list of previous saved searches

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include "customcombobox.h"
#include <QMessageBox>
#include "mainwindow.h"

// Constructor
CustomComboBox::CustomComboBox(QWidget *a_parent) {}

// Handling mouse-events for the list with previous saved searches, so the user can show the list with a click
void CustomComboBox::mouseReleaseEvent(QMouseEvent *a_event)
{
    this->showPopup();
}
