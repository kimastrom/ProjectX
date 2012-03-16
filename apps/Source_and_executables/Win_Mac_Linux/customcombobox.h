// Subclass (header-file) for handling some mouse events for the list of previous saved searches

// Beginning of header-file
#ifndef CUSTOMCOMBOBOX_H
#define CUSTOMCOMBOBOX_H

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include <QComboBox>
#include <QWidget>
#include <QMouseEvent>

// Beginning of the class
class CustomComboBox : public QComboBox // Subclass of the qcombobox, so that we can add extra functionality to the element
{
    Q_OBJECT // A macro for making magic happen, when it comes to calling other classes from a class

// Methods for the class
public:

    // Constructor
    CustomComboBox(QWidget *a_parent);

    // Handling mouse-events for the list with previous saved searches, so the user can show the list with a click
    void mouseReleaseEvent(QMouseEvent *a_event);
};
// Ending of the class

#endif // CUSTOMCOMBOBOX_H
// Ending of header-file
